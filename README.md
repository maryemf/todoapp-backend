## about
Desarrollado en Laravel v8.7.5, compatible con versiones de php ^7.3|^8.0

Se empleo el Repository Pattern para la abastraccion de la capa de acceso a datos.

## use
1. Descargar o clonar desde [repositorio en GitHub](https://github.com/maryemf/todoapp-backend)
2. Instalar las dependencias 
```
composer install
```
3. Generar archivo .env
```
cp .env.example .env
```
4. Generar el Key de la app
```
php artisan key:generate
```
5. Actualizar en el archivo .env la URL de la BD y el password

## create database 
1. Ejecutar el custom command para crear la BD `el usuario debe tener permiso de crear base de datos en el motor` en caso contrario, crear la BD y obviar este paso
```
php artisan make:database DATABASENAME
```
2. Cambiar el nombre de la BD en el archivo .env por el de la DB creada
3. Ejecutar las migraciones para crear las tablas
```
php artisan migrate
```

## run application
Ejecutar 
```
php artisan serve --port=3020 
```

Este puerto esta indicado en la configuracion del front para los llamados al API, en caso de usar otro puerto, se debe cambiar en el front en el archivo `src\environments\environment.ts` 

## swagger
for swagger page go to [Swagger](http://127.0.0.1:3020/api/documentation)
