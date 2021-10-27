# SymfonyChoosit

Un site web, test pour choosit, contenant un catalogue de produits et une gestion de panier basique.

## Environnement de développement

 * PHP 8.0
 * Composer
 * Symfony 5
 * Docker
 * Docker-compose
 
## Lancer l'environnement de développement

```bash
docker-compose up -d
php -S localhost:8080 -t public
```

## Lancer les tests

```bash
php bin/phpunit --testdox
```

## Lancer les Fixtures

```bash
php bin/console doctrine:fixtures:load
```