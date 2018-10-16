
## About Music App

MusicApp is an "WebApi" application which categorizes songs

* List Music Categories
* List Songs By Categories
* Add songs to your favorites

## Technologies

* Laravel 5.7
* MySql (Used seeds to generate mock data)

## Documentation

First run the project then check index page for more details.

## Docker
Docker available to setup this project run command:
docker-compose up

I've used laradock as docker helper for running multiple containers such as nginx, mysql, php-fpm and workspace,
It's included as submodule in project file these are the steps for running containers;

* In order docker to work, docker-compose cli must be installed.
* Navigate to laradock folder
* copy env-example to .env
* run ```docker-compose up -d nginx mysql workspace```
* Open project’s .env file and set the following: ``DB_HOST=mysql``
*  The default username and password for the root MySQL user are ``root and root`` .
* For accessing the container simply run `` docker-compose run workspace bash ``

* For more details please navigate : https://laradock.io

