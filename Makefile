SHELL := /bin/bash

ifneq ("$(wildcard .env)","")
    include .env
    export $(shell sed 's/=.*//' .env)
endif


.PHONY: start stop test

start:
	docker-compose up -d

stop:
	docker-compose down

test:
	docker-compose run --rm app vendor/bin/phpunit

shell:
	docker-compose run --rm app sh

composer:
	docker-compose run --rm app composer $(filter-out $@,$(MAKECMDGOALS))

phpstan:
	docker-compose run --rm app vendor/bin/phpstan analyse src tests

phpcs:
	docker-compose run --rm app vendor/bin/phpcs src tests

phpcs-fix:
	docker-compose run --rm app vendor/bin/phpcbf src tests

%:
	@:
