export COMPOSE_FILE = docker-compose.yml:docker-compose.dev.yml

init:
	git config --local core.hooksPath .githooks/

pint:
	docker compose run php ./vendor/bin/pint

test:
	docker compose run php php artisan test --parallel

test-profile:
	docker compose run php php artisan test --profile

test-coverage:
	docker compose run php php artisan test --coverage

migrate:
	docker compose run php php artisan migrate -v

migrate-fresh:
	docker compose run php php artisan migrate:refresh --seed
