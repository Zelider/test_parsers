<?php
require 'vendor/autoload.php';
include_once('vendor/simple_php_dom/simple_html_dom.php');
include_once('src/spreadsheetCreator.php');
include_once('src/parsingFunctions.php');

use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;

$crawler = createCrawler('https://youla.ru/moskva/zhivotnye');

$lils = $crawler->filter('.product_list');
$lils = $lils
    ->reduce( function ($lil) {
    return ($lil->attr('class') != 'product_item--ad');
} );

foreach($lils->children() as $listing){
    $element = new Crawler($listing);
    $element_title = new Crawler($listing->firstChild);
    $result = array_merge(extractFields(['data-id', 'data-discount'], $element), extractFields(['href', 'title'], $element_title));
    pushToDatabase('yulalisting', $result);
}


