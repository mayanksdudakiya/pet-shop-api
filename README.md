# Pet E-Commerce Shop API - Buckhill Challenge

1) Clone the repository `git clone git@github.com:mayanksdudakiya/pet-shop-api.git`
2) Now, cd into project directory using `cd pet-shop-api`
3) Set your environment variable in .env file `cp .env.example .env`
4) Run the `composer install` command
5) Generate the key `php artisan key:generate`
6) Setup database as you like and run the `php artisan migrate:fresh --seed`
7) Generate private key for the JWT signing key `openssl genpkey -algorithm RSA -out jwt-key.pem`
8) Finally, run the `php artisan serve`