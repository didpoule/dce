# DCE
Site web, regroupant un système de blog et de création d'évènements développé sur Symfony 4 et php 7.1.

## Prérequis
* Maîtrise du langage PHP
* Symfony 4
* npm / webpack
* Javascript
* Savoir utiliser Composer

## Installation

Clonez le projet:

```
$ git clone git://github.com/didpoule/dce.git
```

À l'aide du terminal, deplacez-vous dans le répertoire:

```
$ cd dce
```

Installez les dépendances à l'aide de Composer:

```
$ composer update
```

Mettez à jour le fichier .env:

```
$ nano .env
```

Créez la base de données:

```
$ php bin/console doctrine:schema:create --force
```

Insérez les fixtures:

```
$ php bin/console doctrine:fixtures:load
```

Buildez le front:

```
$ npm run build
```

Donnez les droits à apache:

```
# chown -R www:datas:www-datas ./
```