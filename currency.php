<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Currency</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+TC:wght@300&family=Roboto&display=swap" rel="stylesheet">
  <link rel="icon" href="./image/money.png" type="image/png">
  <link rel="stylesheet" href="spinkit.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <style>
    * {
      font-family: 'Noto Sans TC', 'Roboto', sans-serif;
    }

    body {
      background-color: #212529;
    }

    nav {
      opacity: 0.95;
    }

    canvas {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      z-index: -1;
    }

    .card>img {
      height: 190px;
    }

    .sk-grid {
      background-color: #ffdd07d6;
      margin-right: 3rem;
    }

    .time {
      text-shadow: 1px 1px 1px black;
    }
  </style>
</head>

<body>
  <canvas id="my-canvas"></canvas>
  <nav class="navbar navbar-dark bg-dark sticky-top">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">即時匯率</a>
      <div class="sk-grid">
        <div class="sk-grid-cube"></div>
        <div class="sk-grid-cube"></div>
        <div class="sk-grid-cube"></div>
        <div class="sk-grid-cube"></div>
        <div class="sk-grid-cube"></div>
        <div class="sk-grid-cube"></div>
        <div class="sk-grid-cube"></div>
        <div class="sk-grid-cube"></div>
        <div class="sk-grid-cube"></div>
      </div>
      <a class="navbar-brand" href="https://github.com/joohnny3"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-github text-black" viewBox="0 0 16 16">
          <path d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38 0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82.64-.18 1.32-.27 2-.27.68 0 1.36.09 2 .27 1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.27.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.2 0 .21.15.46.55.38A8.012 8.012 0 0 0 16 8c0-4.42-3.58-8-8-8z" />
        </svg></a>
  </nav>
  <div class="container text-center">
    <div class="row">
      <?php
      date_default_timezone_set('Asia/Taipei');
      $content = file_get_contents('https://tw.rter.info/capi.php');
      $currency = json_decode($content);
      $twM = $currency->USDTWD->Exrate;
      $date = new DateTimeImmutable();
      $amPm = ($date->format('a') == 'am') ? '上午' : '下午';

      foreach ($currency as $key => $value) {
        $value->newExrate = number_format($twM / $value->Exrate, 3);
        $value->twExrate = number_format($value->Exrate / $twM, 3);
      }
      $arrCurrency = [
        ['美國', $currency->USDUSD->newExrate, 'USD', '美元', '#007ab04f', $currency->USDUSD->twExrate],
        ['中國', $currency->USDCNH->newExrate, 'CNH', '人民幣', '#37b03536', $currency->USDCNH->twExrate],
        ['日本', $currency->USDJPY->newExrate, 'JPY', '日圓', '#007ab04f', $currency->USDJPY->twExrate],
        ['韓國', $currency->USDKRW->newExrate, 'KRW', '韓圓', '#37b03536', $currency->USDKRW->twExrate],
        ['香港', $currency->USDHKD->newExrate, 'HKD', '港幣', '#007ab04f', $currency->USDHKD->twExrate],
        ['義大利', $currency->USDEUR->newExrate, 'EUR', '歐元', '#37b03536', $currency->USDEUR->twExrate],
        ['澳洲', $currency->USDAUD->newExrate, 'AUD', '澳元', '#007ab04f', $currency->USDAUD->twExrate],
        ['泰國', $currency->USDTHB->newExrate, 'THB', '泰銖', '#37b03536', $currency->USDTHB->twExrate],
        ['新加坡', $currency->USDSGD->newExrate, 'SGD', '新加坡幣', '#007ab04f', $currency->USDSGD->twExrate],
        ['馬來西亞', $currency->USDMYR->newExrate, 'MYR', '令吉', '#37b03536', $currency->USDMYR->twExrate],
        ['越南', $currency->USDVND->newExrate, 'VND', '越南盾', '#007ab04f', $currency->USDVND->twExrate],
        ['印尼', $currency->USDIDR->newExrate, 'IDR', '印尼盾 ', '#37b03536', $currency->USDIDR->twExrate]
      ];

      for ($i = 0; $i < 12; $i++) {
        print
          "<div class='col-xs-12 col-md-6 col-lg-4 col-xxl-3 mt-4 d-flex justify-content-center'>
    <div class='card' style='width: 18rem;'>
    <img src='./image/{$arrCurrency[$i][2]}.jpg' class='card-img-top' alt='{$arrCurrency[$i][0]}'>
    <div class='card-body' style='background-color:{$arrCurrency[$i][4]};'>
    <p class='card-text text-black fs-6 text-opacity-75'data-taiwna='1 新臺幣 等於'>1 {$arrCurrency[$i][3]} 等於</p>
    <h5 class='card-title fs-4' data-change='{$arrCurrency[$i][5]}{$arrCurrency[$i][3]}'>{$arrCurrency[$i][1]}新臺幣</h5>
    </div>
    </div>
    </div>";
      }
      ?>
    </div>
  </div>
  <div class="position-fixed bottom-0 end-0 text-light time">
    <?= $date->format('n月j日 ' . $amPm . 'H:i [T]．免責聲明'); ?>
  </div>
  <script src="./confetti-js-master/change.js"></script>
  <script src="./confetti-js-master/dist/index.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>

</html>