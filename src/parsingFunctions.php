<?php


use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;
use src\yulaResponceHandler;

/**
 * Метод извлекает требуемые поля из DOM-элемента
 * @param $arr_atr
 * @param $elm
 *
 * @return array
 */
function extractFields($arr_atr, $elm): array
{
    return array_combine($arr_atr, $elm->extract($arr_atr)[0]);
}

/**
 * Метод загружает массив полей в требуемую базу данных
 * @param string $db_name
 * @param array $arr
 *
 * @return void
 */
function pushToDatabase(string $db_name, array $arr)
{

    $conn = new mysqli('localhost', 'a1', '111111', $db_name);

    /*
    $conn->set_charset('utf8');
    mysqli_query($conn, "SET NAMES UTF8");
    mysqli_query($conn, "SET CHARACTER SET UTF8");
    */

    $rsp = new yulaResponceHandler('https://youla.ru/moskva/zhivotnye');
    $ins_arr = $rsp->handleResponce($arr);

    $NewListingQuery = "INSERT INTO yulalisting.listing (data_id, data_discount, href, title) 
                            VALUES ('$ins_arr[0]','$ins_arr[1]', '$ins_arr[2]', '$ins_arr[3]')";
    mysqli_query($conn, $NewListingQuery);
}

/**
 * Метод создает кроулер для требуемого URL
 * @param string $html
 *
 * @return Crawler
 *
 * @throws \GuzzleHttp\Exception\GuzzleException
 */
function createCrawler(string $html) : Crawler
{
    $client = new Client();
    $responce = $client->get($html);
    $htmljs = $responce->getBody()->getContents();

    return new Crawler($htmljs);
}

/**
 * Метод фильтрует результаты использования кроулера по атрибуту класса иб если требуется
 * убирает элементы с нежелательными атрибутами
 * @param Crawler $crw
 * @param string $attr
 * @param string|null $without
 *
 * @return Crawler
 */
function filterClassAttributes(Crawler $crw, string $attr, string $without = null): Crawler
{
    $res_arr = $crw->filter($attr);
    if ($without != null) {
        $res_arr = $res_arr
            ->reduce( function ($resl) use ($without) {
                return ($resl->attr('class') != $without);
            } );
    }

    return $res_arr;
}