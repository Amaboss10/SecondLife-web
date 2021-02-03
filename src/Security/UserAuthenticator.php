<?php

namespace App\Security;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\Exception\InvalidCsrfTokenException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;
use Symfony\Component\Security\Guard\PasswordAuthenticatedInterface;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

class UserAuthenticator extends AbstractFormLoginAuthenticator implements PasswordAuthenticatedInterface
{
    use TargetPathTrait;

    public const LOGIN_ROUTE = 'secondLife_connexion';

    private $entityManager;
    private $urlGenerator;
    private $csrfTokenManager;
    private $passwordEncoder;

    public function __construct(EntityManagerInterface $entityManager, UrlGeneratorInterface $urlGenerator, CsrfTokenManagerInterface $csrfTokenManager,UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->entityManager = $entityManager;
        $this->urlGenerator = $urlGenerator;
        $this->csrfTokenManager = $csrfTokenManager;
        $this->passwordEncoder=$passwordEncoder;
    }

    public function supports(Request $request)
    {

        return self::LOGIN_ROUTE === $request->attributes->get('_route')
            && $request->isMethod('POST');
    }

    public function getCredentials(Request $request)//on recupere les données du formulaire
    {
        $credentials = [
            'email_personne' => $request->request->get('email_personne'),
            'password' => $request->request->get('password'),
            'csrf_token' => $request->request->get('_csrf_token'),
        ];
        $request->getSession()->set(
            Security::LAST_USERNAME,
            $credentials['email_personne']
        );
        return $credentials;
    }

    public function getUser($credentials, UserProviderInterface $userProvider)//verifie si l'user existe dans la bd
    {
        $token = new CsrfToken('authenticate', $credentials['csrf_token']);
        if (!$this->csrfTokenManager->isTokenValid($token)) {
            
            throw new InvalidCsrfTokenException();
        }
        
        //on recupere l'user dans la bd
        $user = $this->entityManager->getRepository(User::class)->findOneBy(['email_personne' => $credentials['email_personne']]);
       
        //si l'user correspondant n'existe pas
        if (!$user) {
            // fail authentication with a custom error
            
            throw new CustomUserMessageAuthenticationException('Il n\' y a pas de compte avec cet email.');
        }
        
        //sinon
        return $user;
    }

    public function checkCredentials($credentials, UserInterface $user)//compare le password du formulaire et celui de la bd
    {
        // Check the user's password or other credentials and return true or false
        // If there are no credentials to check, you can just return true
    
        return $this->passwordEncoder->isPasswordValid($user,$credentials['password']);
        //throw new \Exception('TODO: check the credentials inside '.__FILE__);
    }
    
    public function getPassword($credentials): ?string
    {
        echo "<p>5</p>";
        return $credentials['password'];
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $providerKey)
    {echo "<p>2</p>";
        if ($targetPath = $this->getTargetPath($request->getSession(), $providerKey)) {
            return new RedirectResponse($targetPath);
        }
        //si l'authentification reussit, on est redirigé sur la page d'accueil
        return new RedirectResponse($this->urlGenerator->generate('secondLife_accueil'));
        //throw new \Exception('TODO: provide a valid redirect inside '.__FILE__);
    }

    protected function getLoginUrl()
    {
        return $this->urlGenerator->generate(self::LOGIN_ROUTE);
    }
}
