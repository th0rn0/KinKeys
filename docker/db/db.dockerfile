FROM mysql:5.7
COPY import /docker-entrypoint-initdb.d/
