# Internet cafe application
* How use Vue Router with Laravel
* How to Install AdminLTE 3
* How to Use Font Awesome 5 on Laravel
* How integrate mailchimp with laravel
* How to use Laravel Socialite
* How to Login Using Social Media
* How to Use API in Laravel
* Api Auth with JWT
* Vue Custom Events
* Vue form with Laravel
* Relational Database with Laravel
* Axios and Ajax Request
* ACL in Laravel
* Online Users list
* And much more...

## Getting Started

Clone this project using the following commands:

```
git clone https://github.com/sunnybot10/laravel-vue-spa
cd laravel-vue-spa
```

### Set up the Backend

Create the database and user for the project:

```
mysql -u root -p
CREATE DATABASE laravel-vue-spa CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
GRANT ALL on laravel-vue-spa.* to laravel-vue-spa@127.0.0.1 identified by 'laravel-vue-spa';
quit
```

Copy the example `.env` file:

```
cd laravel-vue-spa
cp .env.example .env
```

Put the database details in the `.env` file:

```
DB_DATABASE=laravel-vue-spa
DB_USERNAME=laravel-vue-spa
DB_PASSWORD=laravel-vue-spa
```


Install the project dependencies, generate a project key, run the migrations and then start the server:

```
composer install
php artisan key:generate
php artisan migrate
php artisan serve
```

Loading [127.0.0.1:8000] now should show the default Laravel login, and [127.0.0.1:8000/register] should show you want to create a user for authorization. 

NOTE: if using a virtual machine and NAT, you might need to run the server as `php artisan serve --host 0.0.0.0` instead.

### Set up the Frontend

```
cd laravel-vue-spa
npm install
npm run watch
```
