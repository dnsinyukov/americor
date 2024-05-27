build:
	docker compose --env-file=./app/.env up -d --build
run:
	docker compose --env-file=./app/.env up -d