# make for windows http://gnuwin32.sourceforge.net/packages/make.htm
DC = docker-compose
CERT_DIR = ./docker/nginx/cert
COMPOSER = $(DC) exec app composer

##help			Shows this help
help:
	@cat Makefile | grep "##." | sed '2d;s/##//;s/://'

##install			Initial setup of application with autostarting containers
build: up-docker composer init restore migrate create-dir-assets create-dir-runtime create-dir-temp

##start			Start containers with checking certificate expires
start: $(DC) up -d

##stop			Down containers (down alias)
stop: down

##codestyle-fix			Run php-cs-fixer
codestyle-fix: ./vendor/bin/php-cs-fixer fix .

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
up-docker:
	$(DC) up --build -d

##composer		Install composer requirements
composer:
	$(COMPOSER) install

##down			Down containers
down:
	$(DC) down

##restore			Restore database
restore:
	docker exec -i pestcontrol-db bash -c "PGPASSWORD=pestcontrol psql -h db -U pestcontrol pestcontrol -f /tmp/pestcontrol.sql"

##create-dir-assets			Create DIR web/assets
create-dir-assets:
	if [ ! -d "web/assets" ]; then mkdir web/assets ; fi

##create-dir-assets			Create DIR web/assets
create-dir-runtime:
	if [ ! -d "runtime" ]; then mkdir runtime ; fi

##create-dir-assets			Create DIR web/assets
create-dir-temp:
	if [ ! -d "temp" ]; then mkdir temp ; fi

%:#Dyrty hack for replace original behavior with goals
	@:

##php-cs-fix-dry		Run PHP CS with option DRY
php-cs-fix-dry:
	$(APP) vendor/bin/php-cs-fixer fix --config .php_cs.dist --dry-run

##php-cs-fix		Run PHP CS
php-cs-fix:
	$(APP)  vendor/bin/php-cs-fixer fix --path-mode=intersection --config .php_cs.dist $(files)