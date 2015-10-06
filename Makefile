.PHONY: test

test:
	vendor/bin/phpunit --testsuite=unit tests
