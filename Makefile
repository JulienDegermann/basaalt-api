SHELL := /bin/bash


SYMFONY = symfony console

cities:
	symfony console app:import-cities
.PHONY: cities

db_reset:
	$(SYMFONY) doctrine:database:drop --force --if-exists
	$(SYMFONY) doctrine:database:create
	$(SYMFONY) make:migration --no-interaction
	$(SYMFONY) doctrine:migrations:migrate --no-interaction
	make cities
	$(SYMFONY) doctrine:fixtures:load --purge-exclusions=city --no-interaction
.PHONY: dbreset

restart:
	symfony server:stop
	symfony console cache:clear
	symfony server:start -d
.PHONY: serverrestart

db:
	$(SYMFONY) make:migration --no-interaction
	$(SYMFONY) doctrine:migrations:migrate --no-interaction
	$(SYMFONY) cache:clear
.PHONY: update_db


setup:
	composer install
	$(SYMFONY) doctrine:database:create
	$(SYMFONY) make:migration --no-interaction
	$(SYMFONY) doctrine:migrations:migrate --no-interaction
	npm install
	$(SYMFONY) doctrine:fixtures:load --no-interaction
.PHONY: setup


datas:
	$(SYMFONY) doctrine:fixtures:load --no-interaction
.PHONY: datas

datasWithCity:
	$(SYMFONY) doctrine:fixtures:load --purge-exclusions=city --no-interaction
.PHONY: datas


update:
	composer update
	npm update
.PHONY: update

build:
	$(SYMFONY) asset-map:compile
	$(SYMFONY) cache:clear
.PHONY: build
