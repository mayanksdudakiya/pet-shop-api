# Pet E-Commerce Shop API - Buckhill Challenge

1) Clone the repository `git clone git@github.com:mayanksdudakiya/pet-shop-api.git`
2) Run the `git submodule update --init --recursive` to clone both packages currency-converter and state-machine packages
3) Now, cd into project directory using `cd pet-shop-api`
4) Set your environment variable in .env file `cp .env.example .env`
5) Run the `composer install` command
6) Generate the key `php artisan key:generate`
7) Setup database as you like and run the `php artisan migrate:fresh --seed`
8) Generate private key for the JWT signing key `openssl genpkey -algorithm RSA -out jwt-key.pem`
9) Finally, run the `php artisan serve`

## Swagger Api Doc Generation

`php artisan l5-swagger:generate`

### Swagger Api Doc URL
`http://127.0.0.1:8000/api/documentation`

## PHP Insights

`php artisan insights`

## PHPStan Analyse

`./vendor/bin/phpstan analyse`

## Test

`php artisan test`


## Insights Results - Exluding package
![image](https://github.com/mayanksdudakiya/pet-shop-api/assets/34036151/a049b7e6-d11e-486d-a049-4b237d8c08bf)

## Test Results
![image](https://github.com/mayanksdudakiya/pet-shop-api/assets/34036151/dbf4dd71-a41a-4a51-8244-fab4d9e97ca4)

## Swagger API demo


https://github.com/mayanksdudakiya/pet-shop-api/assets/34036151/2124542c-b6ff-454a-b5ef-293c5815152f

