<?php
session_start();
if (!isset($_SESSION['id'])){
    header('location:login.php');
}else{
    include('php/conecta.php');
    $id = $_SESSION['id'];
    $script_carrinho = $conn->prepare("SELECT * FROM tb_carrinho WHERE id_user = '$id'");
    $script_carrinho->execute();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="css/carrinho.css">
    <link rel="stylesheet" type="text/css" href="css/navbar.css"> 
    <link rel="stylesheet" type="text/css" href="css/footer.css">
    <script src="js/jquery-3.6.0.min.js"></script>
    
    <title>Meu carrinho</title>
</head>
<body>
    <?php include("php/navbar.php");?>
    <main>
        <div class="title">
            <h1>Carrinho</h1>
        </div>
        <div class="header-carrinho">
            <h4 class="text-produto">Produto</h4>
            <h4 class="text-quant">Quantidade</h4>
            <h4 class="text-total">Total</h4>
        </div>

        <div class="conteudo-carrinho">
            <?php
                // Verificação se tem produtos
                if ($script_carrinho->rowCount() > 0){  
                    foreach($script_carrinho as $item){
                        //puxar produto
                        $id_produto = $item['id_produto'];
                        $script_produtos = $conn->prepare("SELECT * FROM tb_products WHERE id='$id_produto'");
                        $script_produtos->execute();
                        $produto = $script_produtos->fetch(PDO::FETCH_ASSOC);
            ?>
            <div class="prod">
                <div class="image">
                    <img src="img/<?php echo $produto['img_1'];?>">
                </div>
                <div class="desc-prod">
                    <div class="nm-prod">
                        <h5><a href="produto.php/id='<?php echo $id_produto;?>'"><?php echo $produto['nm_produto'];?></a></h5>
                    </div>
                    <div class="vl-prod">
                        <p id="valor">R$ <?php echo $produto['vl_produto'];?></p>
                    </div>
                    <div class="tam-prod">
                        <p>Tamanho: <?php echo $item['tamanho'];?></p>
                    </div>
                </div>
                <div class="quant">
                    <div class="quant-space">
                        <button class="btn decrementButton" data-id-produto="<?php echo $produto['id'];?>"><i class="fas fa-minus"></i></button>
                        <input type="number" class="quantidade" value="<?php echo $item['nr_quant'];?>">
                        <button class="btn incrementButton" data-id-produto="<?php echo $produto['id'];?>"><i class="fas fa-plus"></i></i></button>
                    </div>
                </div>
                <div class="preco-total">
                    <h4>R$ <?php echo $produto['vl_produto'] * $item['nr_quant'];?></h4>
                </div>
            </div>
            <?php
                }
            }else{
                header("Location: catalogo.php");
            }
            ?>
        </div>
        <div class="final-carrinho">
            <div class="info-total">
                <h2></h2>
                <h4>Tributos e frete calculados na finalização da compra</h4>
                <button class="final-button" onclick="window.location.href='checkout.php'">Finalizar compra</button>
            </div>
        </div>
        </div> 
    </main>
    <?php include("php/footer.php");?>

    <script type="text/javascript">
        $(document).ready(function() {
            $('.incrementButton').click(function() {
                var id_produto = $(this).data('id-produto');
                updateNumber('increment', id_produto, $(this));
            });

            $('.decrementButton').click(function() {
                var id_produto = $(this).data('id-produto');
                var quant = $('.quantidade').val();
                if(quant > 1){
                    updateNumber('decrement', id_produto, $(this));
                }
            });

            $('.quantidade').change(function() {
                var id_produto = $(this).closest('.prod').find('.incrementButton').data('id-produto');
                updateNumber('direct', id_produto, $(this));
            });

            function updateNumber(action, id_produto, element) {
                var quantInput = element.closest('.quant-space').find('.quantidade');
                var quant = parseInt(quantInput.val());
                $.ajax({
                    url: 'php/update_quant.php?id='+ id_produto,
                    method: 'POST',
                    data: { action: action, number: quant },
                    success: function(response) {
                        quantInput.val(response);
                        calculateTotalPrice(element);
                        calcularTotal();
                    }
                });
            }

            function calculateTotalPrice(element) {
                var prodDiv = element.closest('.prod');
                var pricePerUnit = parseFloat(prodDiv.find('.vl-prod p').text().replace('R$ ', ''));
                var quant = parseInt(prodDiv.find('.quantidade').val());
                var totalPrice = pricePerUnit * quant;
                prodDiv.find('.preco-total h4').text('R$ ' + totalPrice.toFixed(2));
            }

            function calcularTotal() {
                var total = 0;
                $('.preco-total h4').each(function() {
                    var price = parseFloat($(this).text().replace('R$ ', ''));
                    total += price;
                });
                $('.info-total h2').text('Total: R$ ' + total.toFixed(2));
            }

            calcularTotal();
        });   
    </script>
</body>
</html>
<?php } ?>
