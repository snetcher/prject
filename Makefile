default: up

PROJECT_NAME ?= Prject

help:
	@echo "Available commands:"
	@echo "  help      : Print commands help."
	@echo "  up        : Start up containers."
	@echo "  down      : Down containers."
	@echo "  clean     : Remove all containers, volumes, and data."
	@echo "  reinstall : Clean everything and start fresh installation."
	@echo "  logs      : View WordPress logs."
	@echo "  exec      : Execute command in container (usage: make exec s=service cmd=command)"
	@echo "  shell     : Access container's shell (usage: make shell s=service)"

## up	:	Start up containers.
.PHONY: up
up:
	@echo "Starting up containers for $(PROJECT_NAME)..."
	docker compose pull
	docker compose up -d --remove-orphans

## down	:	Down containers.
.PHONY: down
down:
	@echo "Down containers for $(PROJECT_NAME)..."
	docker compose down

## clean	:	Remove all containers, volumes, and data.
.PHONY: clean
clean:
	@echo "Cleaning up all containers and volumes for $(PROJECT_NAME)..."
	docker compose down -v --remove-orphans
	@echo "Cleanup complete!"

## reinstall	:	Clean everything and start fresh installation.
.PHONY: reinstall
reinstall: clean up
	@echo "Reinstallation complete for $(PROJECT_NAME)! Open http://localhost:8080 to start fresh WordPress installation."

## logs   : View WordPress logs
logs:
	docker compose exec wp tail -f /var/www/html/wp-content/debug.log

## exec	:	Execute command in container (usage: make exec s=service cmd=command)
.PHONY: exec
exec:
	@if not defined s ( \
		echo Please specify a service (s=service). Available services: wp, db, mailpit, phpmyadmin & \
		echo Example: make exec s=wp cmd='wp plugin list' & \
		exit /b 1 \
	)
	@if not defined cmd ( \
		echo Please specify a command (cmd=command) & \
		echo Example: make exec s=wp cmd='wp plugin list' & \
		exit /b 1 \
	)
	docker compose exec $(s) $(cmd)

## shell	:	Access container's shell (usage: make shell s=service)
.PHONY: shell
shell:
	@if not defined s ( \
		echo Please specify a service (s=service). Available services: wp, db, mailpit, phpmyadmin & \
		echo Example: make shell s=wp & \
		exit /b 1 \
	)
	@docker compose exec $(s) bash || docker compose exec $(s) sh
