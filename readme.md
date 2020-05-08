## GottaShit

[![Build Status](https://travis-ci.org/mmanzano/gotta-shit.svg?branch=master)](https://travis-ci.org/mmanzano/gotta-shit)

# Description

A little application in Laravel to mark the best sites to shit.

Technologies:

- Laravel 5.5 (Current LTS)

- Html

- Css (Sass)

- Javascript/Jquery

- Google Maps

## Next Steps

[] Say Goodbye to Google Maps - [leafletjs](https://leafletjs.com)

[] Embrace the backend - [VueJS](https://vuejs.org) under Laravel Mix

[] Improve the css part

### Docker

## How it works

```
chmod +x dadmin
./dadmin build
./dadmin cinstall
./dadmin migrate
./dadmin seed
```

Then you can enter to your copy of the site in `http://localhost:8000`.

## Available commands from dadmin

### ./dadmin build

```
docker-compose up --build -d
```

### ./dadmin cinstall

```
docker-compose exec --user $(id -u) phpproject composer install
```

### ./dadmin key

```
docker-compose exec --user $(id -u) phpproject php artisan key:generate
```

### ./dadmin tinker

```
docker-compose exec phpproject php artisan tinker
```

### ./dadmin migrate

```
docker-compose exec phpproject php artisan migrate
```

### ./dadmin rollback

```
docker-compose exec phpproject php artisan migrate:rollback
```

### ./dadmin seed

```
docker-compose exec phpproject php artisan db:seed
```

### ./dadmin phpunit

```
docker-compose exec --user $(id -u) phpproject ./vendor/bin/phpunit
```

### ./dadmin permissions

Please, execute `git stash -u` before this command. Execute `git stash pop` after. I am opening to suggestions to resolve this permissions issue.

```
docker-compose exec phpproject chmod +777 -R storage/framework
docker-compose exec phpproject chmod +777 -R storage/logs
```

### ./dadmin cc

```
docker-compose exec --user $(id -u) phpproject php artisan config:clear
docker-compose exec --user $(id -u) phpproject php artisan cache:clear
docker-compose exec --user $(id -u) phpproject php artisan view:clear
```

### ./dadmin up

```
docker-compose up -d
```

### ./dadmin stop

```
docker-compose stop
```

### ./dadmin down

```
sudo rm -rf docker-storage
docker-compose down
```

### ./dadmin destroy

This command ***delete all docker containers, images, volumes, networks*** in the current machine (be careful).

```
docker-compose down
docker rm -f $(docker ps -a -q)
docker rmi -f $(docker images -a -q)
docker volume rm $(docker volume ls -q)
docker network rm $(docker network ls | tail -n+2 | awk '{if($2 !~ /bridge|none|host/){ print $1 }}')
```

## License

GottaShit is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
