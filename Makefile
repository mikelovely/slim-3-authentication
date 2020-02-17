SHELL := /bin/bash

up:
	docker network create environment_php_playground || true
	docker-compose -f ./ops/development/docker/db.yml -p mikelovely-playground-database up -d
	docker-compose -f ./ops/development/docker/composer.yml -p mikelovely-playground-composer up --build
	docker-compose -f ./ops/development/docker/fpm.yml -p mikelovely-playground-fpm up -d --build
	docker-compose -f ./ops/development/docker/nginx.yml -p mikelovely-playground-nginx up -d --build

down:
	docker rm -f $$(docker ps -aqf "name=mikelovely-playground-") || true
