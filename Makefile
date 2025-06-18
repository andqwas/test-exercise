docker-start:
	docker compose up --build -d
migrate:
	docker compose exec -d app php artisan migrate --force
queue-work:
	docker compose exec -d app php artisan queue:work
schedule-work:
	docker compose exec -d app php artisan schedule:work
seed:
	docker compose exec -d app php artisan db:seed --force

app-start: docker-start migrate queue-work schedule-work
