dev:
	@php -v
	@php -S localhost:8088 -t example/nginx/public
.PHONY: dev

compose:
	@docker-compose -f example/docker-compose.yml up
.PHONY: compose
