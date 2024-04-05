<?php
    session_start();
    include('php/conecta.php');

    // Exibe todos os produtos
    $sql = "SELECT * FROM tb_products ORDER BY id DESC";
    $consulta_produto = $conn->prepare($sql);
    $consulta_produto->execute();
    $produtos = $consulta_produto->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <link rel="icon" type="image/x-icon" href="./img/CRUZ.webp">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
        <link rel="stylesheet" href="css/footer.css">
        <link rel="stylesheet" href="css/navbar.css">
        <link rel="stylesheet" href="css/catalogo.css">

        <script src="js/jquery-3.6.0.min.js"></script>
        <title>Produtos - DN'TT ®</title>
    </head>
    <body>
        <?php include('php/navbar.php');?>
        <main>
            <div class="list-product">
                <?php
                    if(!isset($produtos)){
                        echo "<h3>Não há produtos a serem exibidos</h3>";
                    }else{
                        foreach ($produtos as $produto) {?>
                            <div class="product">
                                <div class="product-image">
                                    <img src="img/<?php echo $produto['img_1'];?>" onmouseover="changeImage(this, '<?php echo 'img/'.$produto['img_2'];?>')" onmouseout="changeImage(this, '<?php echo 'img/'.$produto['img_1'];?>')" onclick="window.location.href='produto.php?id=<?php echo $produto['nm_produto'];?>'">
                                </div>
                            </div>
                    <?php
                        }
                    }
                ?>
            </div>
        </main>
        <?php include('php/footer.php');?>
        <script>
            function changeImage(element, newImage) {
                element.src = newImage;
            }
        </script>
    </body>
</html>
