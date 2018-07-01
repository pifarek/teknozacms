## Teknoza CMS

### 1. Requirements
 - MySQL server
 - Apache2 server
 - PHP 7.0.0+ installed
 - nodejs
 - Composer

### 2. Automatic Install
 - run the install.php script from command line

### 3. Manual Install

1. git clone https://github.com/pifarek/teknozacms.git
2. create database 'teknozacms'
3. copy .env.example into .env file
4. configure database inside .env file
5. change directories permissions /storage, /bootstrap, /public/upload, /public/assets
6. composer install
7. npm update
8. php artisan key:generate
9. run php artisan migrate --seed

### 4. Credentials

user: admin@teknoza.be
password: administrator
