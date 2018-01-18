live: purge-containers prep-fixtures
	docker-compose -f docker/docker-compose.yml build
	docker-compose -f docker/docker-compose.yml -p kinkeys up -d

prep-fixtures:

purge-containers:
	docker-compose -f docker/docker-compose.yml stop
	docker-compose -f docker/docker-compose.yml rm -vf

app-install:
	# We need to give write permission on the app directory for the webserver.
	# For dev, let's just give write permission to all since changing the owner of this directory will also affect the
	# local machine. We should probably avoid this as could affect our own access to this directory.
	chmod 775 -R *
	chmod -R o+w storage
	chmod 777 -R storage
	chmod 777 -R bootstrap/cache
	# Installation of the app needs to come after the docker services are already up 
	# and running. This is because both database and memcached containers are needed 
	# for migrated the db

# Helper to just clear all docker containers and images
clear-docker-images:
	docker rm $$(docker ps -a -q) -f
	docker rmi $$(docker images -q) -f
