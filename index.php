<?php
  include('php/conecta.php');
?>
<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta property="og:type" content="website">
  <meta property="og:title" content="Dont Trust Any One">
  <meta property="og:description" content="NÃO CONFIE EM NENHUM HOMEM,
NÃO TEMA NENHUMA VADI🚷">
  <meta property="og:image" content="https://dontrustanyone.com/img/cruz_preview.jpg"></meta>
  <meta property="og:width" content="600">
  <meta property="og:heigth" content="600">
  <meta property="og:locale" content="pt_BR">
  <meta property="og:url" content="https://dontrustanyone.com">
  <meta property="og:site_name" content="DN'TT ®">
  <meta property="twitter:card" content="summary_large_image">
  <meta property="twitter:site" content="@dnttanyone"> 
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
  <link rel="icon" type="image/x-icon" href="./img/CRUZ.webp">
  <link rel="stylesheet" href="css/index.css">
  <link rel="stylesheet" href="css/footer.css">
  <link rel="stylesheet" href="css/navbar.css">

  <title>DN'TT ®</title>
</head>
<body>
  <div id="enterPag">
    <div class="enter">
      <center>
        <img src="img/logo.webp" alt="" class="imglogo"><br>
        <h1 id="clickEnter" style="cursor:pointer;">[ENTER]</h1>
      </center>
    </div>
  </div>
  <script>
    nextPag = document.querySelector("#clickEnter").addEventListener("click", bele);
    function bele(){
      document.querySelector("#clickEnter").style.opacity = "0";
      document.querySelector(".imglogo").style.opacity = "0";

      setTimeout(() => {
        window.location.href = "catalogo.php";
      },1000);
    }
  </script>
</body>
</html>
