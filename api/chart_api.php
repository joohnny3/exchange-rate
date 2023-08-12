<?php
header("Access-Control-Allow-Origin: *");
$dsn = "mysql:host=localhost;charset=utf8;dbname=''";
$pdo = new PDO($dsn, 'root', '');
$sql = "SELECT * FROM `exchange_rates` ORDER BY `id` DESC";
$sql_data = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

$chart_data = [];

foreach ($sql_data as $key => $value) {
    $chart_data[$value['currency_id']][] = $value;
}

echo json_encode($chart_data);


/* function dd($array)
{
    print "<pre>";
    print_r($array);
    print "</pre>";
}; */
