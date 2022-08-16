logs:
	docker-compose logs

build:
	docker-compose build

up:
	docker-compose up -d

down:
	docker-compose down

lumen:
	docker-compose exec --user local php_fpm_backend /bin/sh

ps:
	docker-compose ps
