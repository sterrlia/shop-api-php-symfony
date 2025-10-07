.PHONY: lint format

lint:
	@vendor/bin/phpstan analyse src --level=max

format:
	@vendor/bin/php-cs-fixer fix

check-format:
	@vendor/bin/php-cs-fixer fix --dry-run --diff

check: check-format lint
	php bin/console lint:container
