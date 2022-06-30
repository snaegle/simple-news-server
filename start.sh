#! /bin/bash
  
echo "PUTTING APP_SECRET INTO .env FOR LOCAL USE ONLY"
echo "PLEASE STORE APP_SECRET PERMANENTLY IN .env FOR PRODUCTION!"
sed -i s/APP_SECRET.*/APP_SECRET=46b88155092e54854cc6653275165852/ symfony/.env

npm install
docker-compose up -d
docker-compose exec symfony composer update
docker-compose exec symfony bin/console doctrine:database:drop --force
docker-compose exec symfony bin/console doctrine:database:create
docker-compose exec symfony bin/console doctrine:migrations:migrate --no-interaction

