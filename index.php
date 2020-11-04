<?php
require_once 'vendor/autoload.php';


use Sabre\Xml\Service;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Query\QueryBuilder;


require_once 'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();


function database(): Connection
{
    $connectionParams = [
        'dbname' => $_ENV['DB_DATABASE'],
        'user' => $_ENV['DB_USER'],
        'password' => $_ENV['DB_PASSWORD'],
        'host' => $_ENV['DB_HOST'],
        'driver' => 'pdo_mysql',
    ];

    $connection = DriverManager::getConnection($connectionParams);
    $connection->connect();

    return $connection;
}

function query(): QueryBuilder
{
    return database()->createQueryBuilder();
}



$xml=file_get_contents("https://www.bank.lv/vk/ecb_rss.xml");

$service = new Service();
$result = $service->parse($xml);



$rate = $result[0]['value'][9]['value'][3]['value'];



$array = explode(" ", $rate);
$rates = [];

for($i=0;$i<count($array);$i++){
    if($i % 2 == 0){
        $rates[$array[$i]] = $array[$i+1];
    }
}







