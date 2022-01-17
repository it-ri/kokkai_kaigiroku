<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Disposition, Content-Type, Content-Length, Accept-Encoding");
header("Content-type:application/json");

use Elasticsearch\ClientBuilder;
require 'vendor/autoload.php';

if( !empty($_GET['keyword']) ){
  search($_GET['keyword']);
}

function search(string $queryString)
{
  $client = ClientBuilder::create()->build();
  $searchResults = $client->search([
    'index' => 'kokkai_kaigiroku2',
    'body' => [
      'size' => '100', //表示する発言の上限数
      'query' => [
        'multi_match' => [
          'query' => $queryString
        ]
        ],
        'sort' => ['date' => ['order' => 'desc']]
    ]
  ]);

  echo $res = json_encode($searchResults, JSON_UNESCAPED_UNICODE);
  //hits->talk->valueの数字は100件の上限に関わらない，ヒット件数

}

?>
