<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if(php_sapi_name() !== "cli"){
    die('run from command line');
}

if(!function_exists('stream_get_line')){
    die('Cant run on this environment.');
}

exec ("reset");
echo "---- Teknoza CMS installer ----\r\n";

$db_ok = false;

while(!$db_ok){
    echo 'MySQL host ("localhost"): ';
    $db_host = stream_get_line(STDIN, 1024, PHP_EOL);
    if(!$db_host){
        $db_host = 'localhost';
    }
    echo 'MySQL user ("root"): ';
    $db_user = stream_get_line(STDIN, 1024, PHP_EOL);
    if(!$db_user){
        $db_user = 'root';
    }
    echo 'MySQL password: ';
    $db_password = stream_get_line(STDIN, 1024, PHP_EOL);
    echo 'MySQL table: ';
    $db_table = stream_get_line(STDIN, 1024, PHP_EOL);

    @$db = new mysqli($db_host, $db_user, $db_password);

    if($db->connect_error || ! $db->select_db($db_table)){
        echo "Check your MySQL connection ...\r\n\r\n";
    }else{
        $db_ok = true;
    }
}

echo "---- Saving .env file ----\r\n";

$ENV = "APP_ENV=local\r\n";
$ENV .="APP_DEBUG=true\r\n";
$ENV .="APP_KEY=\r\n\r\n";
$ENV .="DB_HOST={$db_host}\r\n";
$ENV .="DB_DATABASE={$db_table}\r\n";
$ENV .="DB_USERNAME={$db_user}\r\n";
$ENV .="DB_PASSWORD={$db_password}\r\n\r\n";
$ENV .="CACHE_DRIVER=file\r\n";
$ENV .="SESSION_DRIVER=file\r\n";
$ENV .="QUEUE_DRIVER=sync\r\n\r\n";
$ENV .="MAIL_DRIVER=smtp\r\n";
$ENV .="MAIL_HOST=\r\n";
$ENV .="MAIL_PORT=\r\n";
$ENV .="MAIL_USERNAME=\r\n";
$ENV .="MAIL_PASSWORD=\r\n";
$ENV .="MAIL_ENCRYPTION=\r\n";
$ENV .="CMS_VERSION=1.0\r\n";

file_put_contents('.env', $ENV);

echo "---- Changing permissions ----\r\n";

exec("chmod -R 777 storage");
exec("chmod -R 777 bootstrap");
exec("chmod -R 777 public/upload");

exec("php artisan cache:clear");
exec("php artisan view:clear");

echo "---- Genereting app key ----\r\n";

exec("php artisan key:generate");

echo "---- Updating environment ----\r\n";

exec("composer dump-autoload");
exec("composer install");
exec("npm update");

echo "---- Seeding Database ----\r\n";

exec("php artisan migrate:refresh --seed");

echo "---- Teknoza CMS installed successfully! ----\r\n";