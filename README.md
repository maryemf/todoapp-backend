## about
Developed in Laravel 9, run in php ^7.3|^8.0

## configure the app
dowload or clone for repository....
rename .env.example to .env
change the database connection parameters


## create database (MySql)
1.- run command: php artisan make:database todoapp
2.- change .env and change the database name for used in previous command (todoapp) DB_DATABASE=todoapp
3.- run: php artisan migrate to create the tables

## run de application
run: php artisan serve --port=3010 this url is used for the front-end application

## swagger
for swagger page go to ....
