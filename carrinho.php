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
                        <h3><a href="produto.php/id='<?php echo $id_produto;?>'"><?php echo $produto['nm_produto'];?></a></h3>
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
                        <input type="number" id="quant" value="<?php echo $item['nr_quant'];?>">
                        <button class="btn incrementButton" data-id-produto="<?php echo $produto['id'];?>"><i class="fas fa-plus"></i></i></button>
                    </div>
                </div>
                <div class="preco-total">
                    <h4>R$ <?php echo $produto['vl_produto']*$item['nr_quant'];?></h4>
                </div>
            </div>
            <?php
                }
            }else{
                header("Location: catalogo.php");
            }
            ?>
        </div>
        <div class="info-total">
            
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
                var quant = $(this).siblings('.quant-space').find('#quant').val();
                if (quant > 1) {
                    updateNumber('decrement', id_produto, $(this));
                }
                calculatTotalProduto();
            });

            function updateNumber(action, id_produto, button) {
                var quant = parseInt(button.siblings('.quant-space').find('#quant').val());
                $.ajax({
                    url: 'php/update_quant.php?id=' + id_produto,
                    method: 'POST',
                    data: { action: action, number: quant },
                    success: function(response) {
                        button.siblings('.quant-space').find('#quant').val(response);
                        calcularTotal();
                    }
                });
            }

            function calcularTotal() {
                var total = 0;
                $('.prod').each(function() {
                    var preco = parseFloat($(this).find('.preco-total h4').text().replace('R$', '').trim());
                    total += preco;
                });
                $('.info-total').text('Total: R$ ' + total.toFixed(2)); 
            }

            calcularTotal();   
        });   
    </script>
</body>
</html>
<?php } ?>
