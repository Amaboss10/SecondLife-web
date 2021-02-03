# Stage_Partie_Site_Web
 Projet: Développement d'une plateforme de vente de composants électroniques et accessoires d'occasion en ligne
 # 1. Pour tester avec le contenu de la base de données
  # 1.1.configuration BD sur Symfony
    Dans le fichier .env, secondLifeUser est le nom de votre bd vous pouvez la modifier
    #DATABASE_URL="sqlite:///%kernel.project_dir%/var/data.db"
    DATABASE_URL="mysql://root:@127.0.0.1:3306/secondLifeUser"
    #DATABASE_URL="postgresql://db_user:db_password@127.0.0.1:5432/db_name?serverVersion=13&charset=utf8"
  # 1.2.Migration
    Si vous n'avez pas encore créer la base de donnees, taper la commande:
    * php bin/console doctrine:database:create
        Ensuite, dans le terminal,taper les commandes
    * php bin/console make:migration
    * php bin/console doctrine:migrations:migrate
    Sinon,
    dans le terminal,taper les commandes
    * php bin/console make:migration
    * php bin/console doctrine:migrations:migrate
 # 2.Pour utiliser les fausses données générées à l'aide de Faker
    *composer require fzaninotto/faker --dev 
    *composer require orm-fixtures --dev
    *php bin/console doctrine:fixtures:load (pour charger les fausses données dans la BD)