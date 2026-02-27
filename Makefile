.PHONY: it
it: fix stan test ## Run the commonly used targets

.PHONY: help
help: ## Displays this list of targets with descriptions
	@grep --extended-regexp '^[a-zA-Z0-9_-]+:.*?## .*$$' $(firstword $(MAKEFILE_LIST)) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}'

setup: composer-update vendor ## Set up the repository

.PHONY: coverage
coverage: vendor ## Collects coverage from running unit tests with phpunit
	mkdir --parents .build/phpunit
	vendor/bin/phpunit --dump-xdebug-filter=.build/phpunit/xdebug-filter.php
	vendor/bin/phpunit --coverage-text --prepend=.build/phpunit/xdebug-filter.php

.PHONY: fix
fix: rector php-cs-fixer ## Fix code automatically

.PHONY: rector
rector: vendor ## Refactor code with rector
	vendor/bin/rector process

.PHONY: php-cs-fixer
php-cs-fixer: vendor ## Fix code style with php-cs-fixer
	mkdir --parents .build/php-cs-fixer
	vendor/bin/php-cs-fixer fix

.PHONY: stan
stan: vendor ## Runs a static analysis with phpstan
	mkdir --parents .build/phpstan
	vendor/bin/phpstan analyse --configuration=phpstan.neon

.PHONY: test
test: vendor ## Runs auto-review, unit, and integration tests with phpunit
	mkdir --parents .build/phpunit
	vendor/bin/phpunit --cache-directory=.build/phpunit

.PHONY: composer-update
composer-update: ## Update dependencies with composer
	composer update

vendor: composer.json
	composer install
	composer validate --strict
	composer normalize
