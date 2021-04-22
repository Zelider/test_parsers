<?php

use GuzzleHttp\Client;

require 'vendor/autoload.php';

$client = new Client();
$ress = $client->get('https://www.liveinternet.ru/rating/ru/485/realty/month.tsv?page=1');
$answ = $ress->getBody()->getContents();
var_dump($answ);