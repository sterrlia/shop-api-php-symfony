.PHONY: lint format

lint:
	@vendor/bin/phpstan analyse src --level=max

format:
	@vendor/bin/php-cs-fixer fix
