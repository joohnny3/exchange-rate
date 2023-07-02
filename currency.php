<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Currency</title>
  <link rel="icon" href="./image/bank.png" type="image/png">
  <link rel="stylesheet" href="spinkit.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <script src="./confetti-js-master/dist/index.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
  <style>
    * {
      font-family: "標楷體", arial, sans-serif;
    }

    body {
      background-color: #212529;
    }

    .container-fluid>svg {
      margin-right: 3rem;
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
      <!-- <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-bank text-light" viewBox="0 0 16 16">
        <path d="m8 0 6.61 3h.89a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5H15v7a.5.5 0 0 1 .485.38l.5 2a.498.498 0 0 1-.485.62H.5a.498.498 0 0 1-.485-.62l.5-2A.501.501 0 0 1 1 13V6H.5a.5.5 0 0 1-.5-.5v-2A.5.5 0 0 1 .5 3h.89L8 0ZM3.777 3h8.447L8 1 3.777 3ZM2 6v7h1V6H2Zm2 0v7h2.5V6H4Zm3.5 0v7h1V6h-1Zm2 0v7H12V6H9.5ZM13 6v7h1V6h-1Zm2-1V4H1v1h14Zm-.39 9H1.39l-.25 1h13.72l-.25-1Z" />
      </svg> -->
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
        $value->Exrate = number_format($twM / $value->Exrate, 2);
      }
      $arrCurrency = [
        ['美國', $currency->USDUSD->Exrate, 'USD', '美元', '#007ab04f'],
        ['中國', $currency->USDCNH->Exrate, 'CNH', '人民幣', '#37b03536'],
        ['日本', $currency->USDJPY->Exrate, 'JPY', '日圓', '#007ab04f'],
        ['韓國', $currency->USDKRW->Exrate, 'KRW', '韓圓', '#37b03536'],
        ['香港', $currency->USDHKD->Exrate, 'HKD', '港幣', '#007ab04f'],
        ['義大利', $currency->USDEUR->Exrate, 'EUR', '歐元', '#37b03536'],
        ['澳洲', $currency->USDAUD->Exrate, 'AUD', '澳元', '#007ab04f'],
        ['泰國', $currency->USDTHB->Exrate, 'THB', '泰銖', '#37b03536'],
        ['新加坡', $currency->USDSGD->Exrate, 'SGD', '新加坡幣', '#007ab04f'],
        ['馬來西亞', $currency->USDMYR->Exrate, 'MYR', '令吉', '#37b03536'],
        ['越南', $currency->USDVND->Exrate, 'VND', '越南盾', '#007ab04f'],
        ['印尼', $currency->USDIDR->Exrate, 'IDR', '印尼盾 ', '#37b03536']
      ];


      // print $currency->USDUSD->Exrate;
      print "<pre>";
      // print_r($arrCurrency);
      print "</pre>";
      for ($i = 0; $i < 12; $i++) {
        print
          "<div class='col-xs-12 col-md-6 col-lg-4 col-xxl-3 mt-4 d-flex justify-content-center'>
      <div class='card' style='width: 18rem;'>
      <img src='./image/{$arrCurrency[$i][2]}.jpg' class='card-img-top' alt='{$arrCurrency[$i][0]}'>
      <div class='card-body' style='background-color:{$arrCurrency[$i][4]};'>
      <p class='card-text text-black fs-6 text-opacity-75'>1 {$arrCurrency[$i][3]} 等於</p>
      <h5 class='card-title fs-4'>{$arrCurrency[$i][1]}新臺幣</h5>
      </div>
      </div>
      </div>";
      }
      ?>
    </div>
  </div>
  <div class="position-fixed bottom-0 end-0 text-black-50">
    <?= $date->format('n月j日 ' . $amPm . 'H:i [T]．免責聲明'); ?>
  </div>
  <script>
    var confettiSettings = {
      target: 'my-canvas'
    };
    var confetti = new ConfettiGenerator(confettiSettings);
    confetti.render();
  </script>
</body>

</html>