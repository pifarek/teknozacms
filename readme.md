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

1. git clone https://github.com/pifarek/teknozacms.git .
2. create database 'teknozacms'
3. configure database inside .env file
4. npm update
5. run php artisan migrate --seed
