## Notification app ##
please run docker-compose 
```
docker-compose up -d
```
exec sh console in to the application container
```
 docker-compose exec notification sh
```
setup database
```
bin/console doctrine:database:create
bin/console doctrine:migrations:migrate --no-interaction
```
run async worker, which actually delivers messages
```
bin/console messenger:consume async
```
in the next console run some test command by running:
```
bin/console test:cli:command
```

### Extending this application ###
simply add another class in the 
```App\Infrastructure\Service\NotificationTransport``` namespace

and make sure it's implementing 
```App\Application\Ports\NotificationTransport``` interface
