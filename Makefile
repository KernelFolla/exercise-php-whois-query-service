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

composer:
	docker-compose run --rm app composer $(filter-out $@,$(MAKECMDGOALS))

%:
	@: