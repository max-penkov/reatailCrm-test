up:
	docker-compose up -d
down:
	docker-compose down --remove-orphans
restart: down up
build:
	docker-compose build
pull:
	docker-compose pull
cli:
	docker-compose run --rm php-cli
composer-install:
	docker-compose run --rm php-cli composer install
init: pull build up
assets-install:
	docker-compose run --rm node npm install
migrations-install:
	docker-compose run --rm php-cli bin/console doctrine:migrations:migrate --no-interaction
fixtures-load:
	docker-compose run --rm php-cli bin/console doctrine:fixtures:load  --purge-with-truncate
generate-api-doc:
	docker-compose run --rm php-cli vendor/bin/openapi module/Application/src --output public/openapi.yml --bootstrap config/openapi.bootstrap.php
