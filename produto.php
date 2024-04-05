<?php
session_start();
    if(!isset($_GET['id'])){
      header('location: catalogo.php');
    }else{
      include('php/conecta.php');
      $nm_produto = $_GET['id'];
      $script_produtos = $conn->prepare("SELECT * FROM tb_products WHERE  nm_produto = '$nm_produto'");
      $script_produtos->execute(); 
      $produto = $script_produtos->fetch(PDO::FETCH_ASSOC);
      $id_produto = $produto['id'];
      $_SESSION['id_produto'] = $id_produto;
    if($script_produtos->rowCount() == 0){
      header("Location: catalogo.php");
    }else{
?>
<!DOCTYPE html>
<html lang="pt-br">
  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <script src="js/jquery-3.6.0.min.js"></script>
      <link rel="stylesheet" href="css/navbar.css">
      <link rel="stylesheet" href="css/produto.css">
      <link rel="stylesheet" href="css/footer.css">

      <title><?php echo $produto['nm_produto'];?></title>
  </head>
  <body>
    <?php include('php/navbar.php');?>
    <main>
        <div class="image">
            <img src="img/<?php echo $produto['img_1'];?>">
        </div>
        <div class="info-prod">
            <div class="nm_prod">
                <h1 class="texto"><?php echo $produto['nm_produto'];?></h1>
            </div>
            <div class="preco">
                <h2 class="texto">R$ <?php echo $produto['vl_produto'];?>.00</h2>
            </div>
            <div class="tam">
                <h4 class="texto">Tamanho</h4>
                <select id="tamanho">
                    <option value="P">P</option>
                    <option value="M">M</option>
                    <option value="G">G</option>
                    <option value="GG">GG</option>
                </select>
            </div>
            <div class="quantidade">
                <h4 class="texto">Quantidade</h4>
                <div class="quant-space">
                    <button class="btn-quant decrementButton"><i class="fas fa-minus"></i></button>
                    <input type="number" name="quant" id="quant" min="1" value="1">
                    <button class="btn-quant incrementButton"><i class="fas fa-plus"></i></i></button>
                </div>
            </div>
            <div class="button-space">
                <button id="cart" type="button" class="btn" id="cart">Adicionar ao carrinho<i class="fas fa-shopping-cart"></i></button>
            </div>
            <span></span>
        </div>
    </main>
    <?php include('php/footer.php');?>

	<!-- JS -->
	<script type="text/javascript">
		$(document).ready(function(){
            //Aumentar quant
            $(".incrementButton").click(function(){
                var oldValue = parseInt($("#quant").val());
                var newVal = oldValue + 1;
                $("#quant").val(newVal);
            });

            // Diminuir quant
            $(".decrementButton").click(function(){
                var oldValue = parseInt($("#quant").val());
                if(oldValue > 1) {
                    var newVal = oldValue - 1;
                    $("#quant").val(newVal);
                }
            });

            $("#cart").click(function(){
                $.ajax({
                    url: "php/script_carrinho.php",
                    type: "GET",
                    data: "id="+<?php echo $produto['id']?>+"&quant="+$("#quant").val()+"&size="+$("#tamanho").val(),
                    dataType: "html"
                }).done(function(resposta) {
                    $("span").html("Adicionado ao carrinho!");
                }).fail(function(jqXHR, textStatus ) {
                    console.log("Request failed: " + textStatus);
                }).always(function() {
                    console.log("completou");
                });
            });
        });
	</script>
</body>
</html>
<?php } } ?>
