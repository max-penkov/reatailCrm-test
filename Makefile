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