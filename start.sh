npm install
docker-compose up -d
docker-compose exec symfony composer update
docker-compose exec symfony bin/console doctrine:database:drop --force
docker-compose exec symfony bin/console doctrine:database:create
docker-compose exec symfony bin/console doctrine:migrations:migrate --no-interaction

