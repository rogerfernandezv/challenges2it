<p align="center"><img src="https://semcomp.icmc.usp.br/20/media/empresas/s2it.png.400x130_q85.png"></p>

## About

Challenge

## Installation

```bash
# clone repository
git clone https://github.com/rogerfernandezv/challenges2it.git

# Access the folder
cd challenges2it

# install components
composer install

# copy env
cp .env.example .env

# key generate
php artisan key:generate

# configure database on .env here simple example
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=homestead
DB_USERNAME=homestead
DB_PASSWORD=secret

# migrate
php artisan migrate

# to testing using php builtin server
php artisan serve

# go to http://localhost:8000

# for unit test
composer test

```

## How to use

To test you can use Postman:
https://www.getpostman.com/

|      						| Method 	| Body 	| Description
| ---      					| ---       | ---	| ---
| /api/people  				| GET       | 		| list all peoples
| /api/people/{id}  		| GET       | 		| people detail with id = {id}
| /api/order  				| GET    	| 		| list all orders
| /api/order/{id}  			| GET    	| 		| order detail with id = {id}
| /api				  		| GET    	| 		| show endpoints

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
