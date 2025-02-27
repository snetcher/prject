default: up

PROJECT_NAME ?= Hertland Concept

help:
	@echo "Available commands:"
	@echo "  help      : Print commands help."
	@echo "  up        : Start up containers."
	@echo "  down      : Down containers."
	@echo "  clean     : Remove all containers, volumes, and data."
	@echo "  reinstall : Clean everything and start fresh installation."

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
