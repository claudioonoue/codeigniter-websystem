d-start:
	@echo '🐋🚀 Starting containers... 🚀🐋'
	@docker-compose --env-file ./.docker.env up -d

d-stop:
	@echo '🐋🛑 Stopping containers... 🛑🐋'
	@docker-compose --env-file ./.docker.env down