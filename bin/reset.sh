#!/bin/bash

ENV="$1"

if [ "$ENV" == "" ]; then
	ENV="dev"
fi

php app/console doctrine:database:drop --connection=default --force --env=$ENV
php app/console doctrine:database:create --connection=default --env=$ENV
php app/console doctrine:schema:update --em=default --force --env=$ENV
php app/console doctrine:fixtures:load --em=default --no-interaction --append --env=$ENV
