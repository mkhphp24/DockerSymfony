
docker-compose down && docker-compose up -d
docker rm -f $(docker ps -a -q)

phpmyadmin URL : http://localhost:8080/index.php;
user:root pass:root
WEB URL : http://localhost:8000/

DATABASE_URL=mysql://root:root@mysqldb:3306/test?serverVersion=5.7

docker-compose exec php ls
docker-compose exec php ./bin/console debug:router
docker-compose exec php ./bin/console make:controller HomeController

docker-compose exec php ./bin/console make:entity
docker-compose exec php ./bin/console make:migration
docker-compose exec php ./bin/console d:mig:mig



