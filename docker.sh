#!/bin/bash

composer install
composer update
npm install --force && npm run build
# npm run build
php bin/console doctrine:migrations:migrate
composer require doctrine/doctrine-fixtures-bundle

# php bin/console app:import-cities
# php bin/console doctrine:fixtures:load --no-interaction
# composer remove symfony/apache-pack
# composer require symfony/apache-pack -y
exec apache2-foreground
# exec make db_start_datas
