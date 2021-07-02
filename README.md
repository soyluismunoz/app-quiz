# 🧠 App - quiz

## Sobre Certificaciones

Es una web app en donde crear pequenos quiz en donde podras asignarle distintas caracteristicas a cada uno de ellos, algunas caracteristicas son, asignarle un tiempo limite para realizar la certificacion, crear mensaje en caso de que apruebe, y en caso de de que repruebe, entre otras.

## Tecnologias utilizadas
- PHP
- Laravel framework 7,
- Mysql
- Vuejs 2.6
- Bootstrap 4.5

## Instalación 

Clonar repositorio
```
git clone git@github.com:soyluismunoz/app-quiz.git
```

Ir a la carpeta
``` 
cd app-quiz 
```

Instalar dependencias PHP
```
composer install
```

Crear archivo de variables de entorno
```
cp .env.example .env
```

Generar llave 
```
php artisan key:generate
```

Conexion con la base de datos
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=my-db
DB_USERNAME=my-user
DB_PASSWORD=my-password
```

Crear tablas y generar los seeders
```
php artisan migrate --seed
```

Instalar dependencias Javascript
```
npm install
```

```
npm run dev
```

Iniciar virtual server
```
php artisan server
```
## Demo
**Url** : http://quiz-certifications.herokuapp.com/

### Usuario administrador

**Email**: john@example.com
**PASS**: 123456

### Usuario standar

**Email**: jody@example.net
**PASS**: 123456

## Capturas 
![captura](https://i.imgur.com/ut47YiT.png)
***

![captura](https://i.imgur.com/3GamgRK.png)
***

![captura](https://i.imgur.com/am70JyH.png)
***

![captura](https://i.imgur.com/ngdqWG6.png)
