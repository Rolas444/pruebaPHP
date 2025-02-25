.PHONY: up down init test

up:
    docker-compose up -d

down:
    docker-compose down

create-db:
    docker-compose exec mysql bash -c "mysql -u$$MYSQL_USER -p$$MYSQL_PASSWORD -e 'CREATE DATABASE IF NOT EXISTS $$DB_NAME;'"
    docker-compose exec mysql bash -c "mysql -u$$SECOND_DB_USER -p$$SECOND_DB_PASSWORD -e 'CREATE DATABASE IF NOT EXISTS $$TEST_DB_NAME;'"

init: up
    docker-compose exec php bash -c "composer install && php vendor/bin/doctrine-migrations migrate"

test:
    docker-compose exec php bash -c "php vendor/bin/phpunit --testsuite 'Integration Tests'"