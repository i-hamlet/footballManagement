.PHONY: up, php, stop, network

network: ##Creates docker network
	docker network create app-net
up: ##Bringing up the containers
	docker-compose up -d
install: ##Bringing up the containers and install dependencies
	docker-compose up -d
	docker-compose exec php bash -c "composer install"
	docker-compose exec php bash -c "npm install"
	docker-compose exec php bash -c "npm run build"
stop: ##Stop containers
	docker-compose down
test: ##Execute unit tests
	docker-compose exec php bash -c "vendor/bin/phpunit"
php: ##Execute php container bash
	docker exec -ti footballmanagement-php-1 bash
db:	##Recreate database for dev
	docker-compose exec php bash -c "bin/console doctrine:schema:drop --force --full-database -qn --env=dev"
	docker-compose exec php bash -c "bin/console doctrine:migration:migrate -qn --env=dev"
	docker-compose exec php bash -c "bin/console doctrine:fixtures:load -qn --env=dev"





help:
		@awk -F ':|##' '/^[^\t].+?:.*?##/ {\
		printf "\033[36m%-30s\033[0m %s\n", $$1, $$NF \
		}' $(MAKEFILE_LIST)
.DEFAULT_GOAL=help