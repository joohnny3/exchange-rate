<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Currency</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
  <style>
    * {
      font-family: "標楷體";
    }
  </style>
</head>

<body>
  <nav class="navbar navbar-dark bg-dark sticky-top">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">即時匯率</a>
      <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-bank text-light" viewBox="0 0 16 16">
        <path d="m8 0 6.61 3h.89a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5H15v7a.5.5 0 0 1 .485.38l.5 2a.498.498 0 0 1-.485.62H.5a.498.498 0 0 1-.485-.62l.5-2A.501.501 0 0 1 1 13V6H.5a.5.5 0 0 1-.5-.5v-2A.5.5 0 0 1 .5 3h.89L8 0ZM3.777 3h8.447L8 1 3.777 3ZM2 6v7h1V6H2Zm2 0v7h2.5V6H4Zm3.5 0v7h1V6h-1Zm2 0v7H12V6H9.5ZM13 6v7h1V6h-1Zm2-1V4H1v1h14Zm-.39 9H1.39l-.25 1h13.72l-.25-1Z" />
      </svg>
      <a class="navbar-brand" href="https://github.com/joohnny3"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-github" viewBox="0 0 16 16">
          <path d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38 0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82.64-.18 1.32-.27 2-.27.68 0 1.36.09 2 .27 1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.27.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.2 0 .21.15.46.55.38A8.012 8.012 0 0 0 16 8c0-4.42-3.58-8-8-8z" />
        </svg></a>
  </nav>
  <div class="container text-center mt-3">
    <div class="row">
      <?php
      $content=file_get_contents('https://tw.rter.info/capi.php');
      $currency=json_decode($content);
      $twM = $currency->USDTWD->Exrate;
      foreach ($currency as $key => $value) {
        $value->Exrate *= $twM;
      }


      print "<pre>";
      print_r($currency);
      print "</pre>";
      for ($i = 0; $i < 14; $i++) {
        print
          "<div class='col-xs-12 col-md-6 col-lg-4 col-xxl-3 mt-4'>
            <div class='card' style='width: 18rem;'>
            <img src='...' class='card-img-top' alt='...'>
              <div class='card-body'>
              <p class='card-text'>1 美元 等於</p>
              <h5 class='card-title'>{$i}新臺幣</h5>
              </div>
            </div>
          </div>";
      }
      ?>
      </div>
    </div>
      <!-- <div class="col-xs-12 col-md-6 col-lg-4 col-xxl-3">
        <div class="card" style="width: 18rem;">
          <img src="..." class="card-img-top" alt="...">
          <div class="card-body">
            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
            <h5 class="card-title">Card title</h5>
          </div>
        </div>
      </div>
      <div class="col-xs-12 col-md-6 col-lg-4 col-xxl-3">
        <div class="card" style="width: 18rem;">
          <img src="..." class="card-img-top" alt="...">
          <div class="card-body">
            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
            <h5 class="card-title">Card title</h5>
          </div>
        </div>
      </div>
      <div class="col-xs-12 col-md-6 col-lg-4 col-xxl-3">3</div>
      <div class="col-xs-12 col-md-6 col-lg-4 col-xxl-3">4</div>
      <div class="col-xs-12 col-md-6 col-lg-4 col-xxl-3">1</div>
      <div class="col-xs-12 col-md-6 col-lg-4 col-xxl-3">2</div>
      <div class="col-xs-12 col-md-6 col-lg-4 col-xxl-3">3</div>
      <div class="col-xs-12 col-md-6 col-lg-4 col-xxl-3">4</div>
      <div class="col-xs-12 col-md-6 col-lg-4 col-xxl-3">1</div>
      <div class="col-xs-12 col-md-6 col-lg-4 col-xxl-3">2</div>
      <div class="col-xs-12 col-md-6 col-lg-4 col-xxl-3">3</div>
      <div class="col-xs-12 col-md-6 col-lg-4 col-xxl-3">4</div> -->
</body>

</html>