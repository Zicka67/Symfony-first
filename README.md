# Symfony-first

Bien penser à faire un      composer install     à la racine du projet à chaque pull, pour réinstaller
vendor qui n'est pas charger sur git

Glossaire : Doctrine -> ORM ( Object Relational Mapping ) ou couche d'abstraction


---------------------------------------------------------------------


<mark>Commande liste</mark> : 
Créer un nouoveau projet
symfony new NomDuProjet --full (ou –webapp en Symfony 6 pour PHP8.X)

Lancer le serveur de Symfony
symfony server:start
symfony serve
symfony server:start -d (pour lancer le serveur en arrière-plan)
symfony serve -d

Stopper le serveur
symfony server:stop

Créer une nouvelle entity (ou mettre à jour une entity existante)
symfony console make:entity (ou m:e)

Créer la base de données
symfony console doctrine:database:create

Effectuer la migration (2 étapes !)
symfony console make:migration (ou m:mi)
symfony console doctrine:migrations:migrate (ou d:m:m)

Mettre à jour la base de données après ajout d'un attribut dans une entité
symfony console doctrine:schema:update --force (ou d:s:u --force)

Créer un nouveau controller
symfony console make:controller Home (ou m:con)

--> création de HomeController
Créer un nouveau form type
symfony console make:form

Vider le cache
symfony console cache:clear

Commandes liées à l'authentification
symfony console make:user
symfony console make:registration-form
symfony console make:auth

Vérification d'email + reset password
composer require symfonycasts/verify-email-bundle
composer require symfonycasts/reset-password-bundle
symfony console make:reset-password
