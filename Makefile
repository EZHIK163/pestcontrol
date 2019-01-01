# make for windows http://gnuwin32.sourceforge.net/packages/make.htm
DC = docker-compose
CERT_DIR = ./docker/nginx/cert
COMPOSER = $(DC) exec app composer

##help			Shows this help
help:
	@cat Makefile | grep "##." | sed '2d;s/##//;s/://'

##install			Initial setup of application with autostarting containers
build: up composer init restore migrate create-dir-assets

##start			Start containers with checking certificate expires
start: $(DC) up -d

##stop			Down containers (down alias)
stop: down

##migrate			Run migrations
migrate:
	$(DC) exec app php yii migrate --interactive=0

##init			Init application
init:
	if [ ! -f config/serv.env ]; then cp config/serv_example.env config/serv.env ; fi

##bash			Open the app container bash
bash:
	$(DC) exec app bash

##up			Up containers with rebuild
up:
	$(DC) up --build -d

##composer		Install composer requirements
composer:
	$(COMPOSER) install

##down			Down containers
down:
	$(DC) down

##restore			Restore database
restore:
	docker exec db psql -h db -U pestcontrol_old -d pestcontrol_old -f /tmp/pestcontrol.sql

##create-dir-assets			Create DIR web/assets
create-dir-assets:
	mkdir web/assets

%:#Dyrty hack for replace original behavior with goals
	@:
