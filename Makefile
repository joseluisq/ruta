docker-tests:
	@echo "Testing Ruta with PHP 8.0"
	@docker run --rm -it -v $(PWD):/var/www/html joseluisq/php-fpm:8.0 \
		sh -c 'php -v && composer install && composer run-script test'
	@echo
	@echo "Testing Ruta with PHP 8.1"
	@docker run --rm -it -v $(PWD):/var/www/html joseluisq/php-fpm:8.1 \
		sh -c 'php -v && composer install && composer run-script test'
.PHONY: docker-tests

compose-up:
	@cd example/nginx/public/ && composer install
	@docker-compose -f example/docker-compose.yml up
.PHONY: compose-up

compose-down:
	@docker-compose -f example/docker-compose.yml down
.PHONY: compose-down

container-dev:
	@docker run --rm \
		--name ruta \
		-p 8088:8088 \
		-v $(PWD)/example/nginx/public:/usr/share/nginx/html/ \
      	-v $(PWD)/src:/usr/src \
		joseluisq/php-fpm:8.1 sh -c "php -S 0.0.0.0:8088 -t /usr/share/nginx/html/"
.PHONY: container-dev
