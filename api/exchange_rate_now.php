<?php
header("Access-Control-Allow-Origin: *");
$content = file_get_contents('https://tw.rter.info/capi.php');
$exchange_rate = json_decode($content);
$exchangeTwd = $exchange_rate->USDTWD->Exrate;


foreach ($exchange_rate as $key => $value) {
    $value->newExrate = number_format($exchangeTwd / $value->Exrate, 3);
    $value->twExrate = number_format($value->Exrate / $exchangeTwd, 3);
}


$arrCurrency = [
    ['美國', $exchange_rate->USDUSD->newExrate, 'USD', '美元', '#ffe40742', $exchange_rate->USDUSD->twExrate],
    ['中國', $exchange_rate->USDCNH->newExrate, 'CNH', '人民幣', '#f8f9fa', $exchange_rate->USDCNH->twExrate],
    ['日本', $exchange_rate->USDJPY->newExrate, 'JPY', '日圓', '#ffe40742', $exchange_rate->USDJPY->twExrate],
    ['韓國', $exchange_rate->USDKRW->newExrate, 'KRW', '韓圓', '#f8f9fa', $exchange_rate->USDKRW->twExrate],
    ['香港', $exchange_rate->USDHKD->newExrate, 'HKD', '港幣', '#ffe40742', $exchange_rate->USDHKD->twExrate],
    ['義大利', $exchange_rate->USDEUR->newExrate, 'EUR', '歐元', '#f8f9fa', $exchange_rate->USDEUR->twExrate],
    ['澳洲', $exchange_rate->USDAUD->newExrate, 'AUD', '澳元', '#ffe40742', $exchange_rate->USDAUD->twExrate],
    ['泰國', $exchange_rate->USDTHB->newExrate, 'THB', '泰銖', '#f8f9fa', $exchange_rate->USDTHB->twExrate],
    ['新加坡', $exchange_rate->USDSGD->newExrate, 'SGD', '新加坡幣', '#ffe40742', $exchange_rate->USDSGD->twExrate],
    ['馬來西亞', $exchange_rate->USDMYR->newExrate, 'MYR', '令吉', '#f8f9fa', $exchange_rate->USDMYR->twExrate],
    ['越南', $exchange_rate->USDVND->newExrate, 'VND', '越南盾', '#ffe40742', $exchange_rate->USDVND->twExrate],
    ['印尼', $exchange_rate->USDIDR->newExrate, 'IDR', '印尼盾 ', '#f8f9fa', $exchange_rate->USDIDR->twExrate]
];


echo json_encode($arrCurrency);



