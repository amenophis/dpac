COLOR_RESET   = \033[0m
COLOR_SUCCESS = \033[32m
COLOR_ERROR   = \033[31m
COLOR_COMMENT = \033[33m

define log
	echo "[$(COLOR_COMMENT)$(shell date +"%T")$(COLOR_RESET)][$(COLOR_COMMENT)$(@)$(COLOR_RESET)] $(COLOR_COMMENT)$(1)$(COLOR_RESET)"
endef

define log_success
	echo "[$(COLOR_SUCCESS)$(shell date +"%T")$(COLOR_RESET)][$(COLOR_SUCCESS)$(@)$(COLOR_RESET)] $(COLOR_SUCCESS)$(1)$(COLOR_RESET)"
endef

define log_error
	echo "[$(COLOR_ERROR)$(shell date +"%T")$(COLOR_RESET)][$(COLOR_ERROR)$(@)$(COLOR_RESET)] $(COLOR_ERROR)$(1)$(COLOR_RESET)"
endef

CURRENT_USER := $(shell id -u)
CURRENT_GROUP := $(shell id -g)

TTY   := $(shell tty -s || echo '-T')
DOCKER_COMPOSE := FIXUID=$(CURRENT_USER) FIXGID=$(CURRENT_GROUP) docker-compose
PHP_RUN := $(DOCKER_COMPOSE) run $(TTY) --no-deps --rm php
PHP_EXEC := $(DOCKER_COMPOSE) exec $(TTY) php

.DEFAULT_GOAL := help
.PHONY: help
help:
	@grep -E '(^[a-zA-Z_-]+:.*?##.*$$)|(^##)' $$(echo '$(MAKEFILE_LIST)' | cut -d ' ' -f2) | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'

var:
	@mkdir -p var

build: var/docker.build ## Build the docker stack
var/docker.build: var docker/php/Dockerfile docker/nginx/Dockerfile
	@$(call log,Building docker images ...)
	@$(DOCKER_COMPOSE) build
	@touch var/docker.build
	@$(call log_success,Done)

.PHONY: pull
pull: ## Pulling docker images
	@$(call log,Pulling docker images ...)
	@$(DOCKER_COMPOSE) pull
	@$(call log_success,Done)

.PHONY: shell
shell: start ## Enter in the PHP container
	@$(call log,Entering inside php container ...)
	@$(DOCKER_COMPOSE) exec php ash

start: var/docker.up ## Start the docker stack
var/docker.up: var var/docker.build
	@$(call log,Starting the docker stack ...)
	@$(DOCKER_COMPOSE) up -d
	@touch var/docker.up
	@$(call log,View to the API documentation: http://127.0.0.1:8000/)
	@$(call log_success,Done)

.PHONY: stop
stop: ## Stop the docker stack
	@$(call log,Stopping the docker stack ...)
	@$(DOCKER_COMPOSE) stop
	@rm -rf var/docker.up
	@$(call log_success,Done)

.PHONY: clean
clean: stop ## Clean the docker stack
	@$(call log,Cleaning the docker stack ...)
	@$(DOCKER_COMPOSE) down
	@rm -rf var/
	@$(call log_success,Done)
