<?php

$dsn = "mysql:host=localhost;charset=utf8;dbname=exchange_rate";
$pdo = new PDO($dsn, 'root', '');

$sql = "SELECT * FROM `exchange_rates`";
$sql_data = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

// dd($chart_date);
$chart_data = [];

foreach ($sql_data as $key => $value) {
    $chart_data[$value['currency_id']][] = $value;
    // dd($value);
}

echo json_encode($chart_data);

dd($chart_data);

function dd($array)
{
    print "<pre>";
    print_r($array);
    print "</pre>";
};
