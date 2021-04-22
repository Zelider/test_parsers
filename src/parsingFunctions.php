<?php

use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;
use yulaResponceHandler;

function extractFields($arr_atr, $elm)
{
    return array_combine($arr_atr, $elm->extract($arr_atr)[0]);
}

function pushToDatabase($db_name, $arr)
{

    $conn = new mysqli('localhost', 'a1', '111111', $db_name);

    /*
    $conn->set_charset('utf8');
    mysqli_query($conn, "SET NAMES UTF8");
    mysqli_query($conn, "SET CHARACTER SET UTF8");
    */

    $rsp = new yulaResponceHandler();
    $ins_arr = $rsp->handleResponce($arr);

    $NewListingQuery = "INSERT INTO yulalisting.listing (data_id, data_discount, href, title) VALUES ('$ins_arr[0]','$ins_arr[1]', '$ins_arr[2]', '$ins_arr[3]')";
    mysqli_query($conn, $NewListingQuery);

    //$res = mysqli_query($conn, "SELECT title FROM yulalisting.listing LIMIT 10");
    //var_dump($res->fetch_assoc());
    //$res->close();
}

function createCrawler($html) : Crawler
{
    //$html = 'https://youla.ru/moskva/zhivotnye'; // type string
    $client = new Client();
    $responce = $client->get($html);
    $htmljs = $responce->getBody()->getContents();

    return new Crawler($htmljs);
}
