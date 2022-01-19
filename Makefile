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
