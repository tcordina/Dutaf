Dutaf - Symfony 3
==================

Dutaf est un site de gestion d'articles et de fournisseurs

1 - Installation des dépendances 
----------------

Tout d'abord, plaçons-nous dans le dossier racine du projet grace à cette commande : 

````
$ cd /chemin_vers_la_racine_du_projet
````


Pour que l'application fonctionne, il faut installer ses différentes dépendances. Ici nous avons composer installé en variable d'environnement. 

````
$ composer update
````

les informations demandées lors de l'execution de `composer update` remplissent le fichier parameters.yml

Il faut ensuite mettre-à-jour l'autoloading de composer avec la commande suivante : 

````
$ composer dump-autoload -o
````

2 - Mise en place de la base de données
----------------

Il faut ensuite créer la base de donnée qui accueillera les tables du projet soit dirrectement via la console avec

````
$ php bin/console doctrine:database:create
````

soit via l'interface de phpmyadmin

Nous allons ensuite générer les différentes tables avec la commande suivante :

````
$ php bin/console doctrine:schema:update --force
````

La structure de ces tables s'appuie sur les fichiers d'entité disponibles dans le dossier `src/Dutaf/DutafBundle/Entity`

3 - Création du compte d'administration
-----------------

La manière la plus simple est de se rendre sur phpmyadmin et d'insérer directement les informations dans la table `user`
On y trouver 3 champs
  Le champs id : à laisser vide
  Le champs username : on y met ce qu'on veut
  Le champs password : Encrypter le mdp de notre choix avec https://www.bcrypt.fr/ puis copier le résultat dans la table
  
On peut aussi utiliser le bundle Fixtures (https://symfony.com/doc/master/bundles/DoctrineFixturesBundle)

4 - Création des articles et fournisseurs
-----------------

On peut maintenant se connecter à l'espace d'administration pour ajouter les différents articles et fournisseurs.
Il faudra commencer par les fournisseurs à cause de la relation many-to-one.
