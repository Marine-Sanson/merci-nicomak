# Merci-nicomak
Test technique pour la société Nicomak

## Pour faire tourner ce projet :

Commencer par faire la ligne de commande suivante :

```
composer install
```

Copiez le fichier ```.env``` dans un fichier ```.env.local``` et remplacer les données par les votres.

Pour créer la base de données exécuter la commande suivante : 

```
php bin/console doctrine:database:create
``` 

Pour créer les tables faire une migration :
```
php bin/console doctrine:migrations:migrate
```

Vous trouverez un petit jeu de données que vous pourrez charger dans le dossier document.

Pour faire tourner ce projet vous pouvez utiliser le server de symfony :
```
symfony server:start -d
```

## Pour se connecter :

Pour vous connecter si vous avez chargé le jeu de données vous pouvez utiliser chacun·e des 6 utilisat·eur·rices en utilisant son prénom et le mot de passe, très original suivant : *mdpass*

## J'espère que ce projet va vous plaire, n'hésitez pas à revenir vers moi si vous avez des questions !
