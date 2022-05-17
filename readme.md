     # Sandrine Coupart
     ### Diététicienne nutritionniste

lien : https://dietdietetic.herokuapp.com/ | https://git.heroku.com/dietdietetic.git

Sandrine Coupart est un site internet présentant à la fois les services de son cabinet de Diététicienne nutritionniste, et
des recettes pour des régimes Spécifiques, accessible via des comptes qu'elle créer pour ses patients. Elle rend aussi accessible quelques recettes de bases aux visiteurs afin de permettre à chacun de découvrir et de partager de bons conseils culinaire.

## Environnement de développement

### Les pré-requis

. PHP 8
. Composer
. Symfony CLI
. MySQL / PostGreSQL / ...
. PhpMyAdmin

### Lancement de l'environnement de Dev

Dans la console:
symfony serve -d ou symfony server:start

## Utilisation du site

### Créer la base de donnée

symfony console doctrine:database:create (ou symfony console d:d:c))

##### Ajouter les migrations :

symfony console doctrine:migrations:migrate (ou symfony console d:m:m)

##### Ajouter les fixtures (pour tester le site):

1. Vérifier dans config > bundles.php que
   Twig\Extra\TwigExtraBundle\TwigExtraBundle::class => ['all' => true],

sinon

Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle::class => ['dev' => true, 'test' => true],

2. Ensuite entrer la commande suivante dans le terminal :
   symfony console doctrine:fixtures:load (ou symfony console d:f:l)

