# BexSoluciones
## _Technical test_

[![Build Status](https://travis-ci.org/joemccann/dillinger.svg?branch=master)](https://travis-ci.org/joemccann/dillinger)

Proyecto api desarrollado con patrones de diseño como Test Driven Design y Domain Driven Design, esto con el fin de hacer un codigo limpio y escalable en el tiempo.

Se usaron las con las siguientes tecnologias

- Laravel 9
- PHP 8
- Jwt
- Docker
- Docker Compose
- Postgres


## DB connection
Para la conexion con la base de datos use como credenciales por defecto `` user: postgres``, ``password: postgres``, y el host es el `` container_name `` del servicio de base de datos, en este caso es ``db-ddd``.

La base de datos se crea en una carpeta local del proyecto, la cual se llama ``pgdata``, esta carpeta esta incluida en el archivo gitignore.

## Run Project

Para instalar el proyecto use el siguiente comando:
```
docker-compose up --build
```

Para ejecutar las migraciones, use le siguiente comando:
```
docker-compose run app php artisan migrate:fresh --seed
```

Para ejecutar las pruebas de aceptacion, use le siguiente comando:
```
docker-compose run app php artisan test
```

Recuerde enviar el token de autenticacion en el header de la peticion de la siguiente manera, en donde "{{token}}" es el token de usuario:
```
Authorization: Bearer {{token}}
```
 ## Routes
 
 El proyecto cuenta con los siguientes endpoints:
 
 ### Auth
 Rutas de autenticacion:
 
 #### Token Required
 - POST: http://127.0.0.1:80/api/v1/user
 - POST: http://127.0.0.1:80/api/v1/refresh
 - POST: http://127.0.0.1:80/api/v1/logout

#### Token Not Required
 - POST: http://127.0.0.1:80/api/v1/register
 - POST: http://127.0.0.1:80/api/v1/login

 ### Users
 Rutas Crud tabla usuarios.
 
  #### Token Required
 - GET: http://127.0.0.1:80/api/v1/users
 - POST: http://127.0.0.1:80/api/v1/users
 - PUT: http://127.0.0.1:80/api/v1/users/{{ID}}
 - GET: http://127.0.0.1:80/api/v1/users/{{ID}}
 - DELETE: http://127.0.0.1:80/api/v1/users/{{ID}}