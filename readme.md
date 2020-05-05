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

[] Improve the css part - [Tailwind](https://tailwindcss.com)

### Docker

#### up

docker-compose up --build -d

#### composer install

docker-compose exec --user $(id -u) phpgottashit composer install

#### migrate

docker-compose exec phpgottashit php artisan migrate

#### seed

docker-compose exec phpgottashit php artisan db:seed

#### tests

docker-compose exec --user $(id -u) phpgottashit ./vendor/bin/phpunit

#### destroy

docker-compose down

## License

GottaShit is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
