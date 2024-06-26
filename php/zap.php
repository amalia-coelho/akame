<?php
// Verificando se os campos estão preenchidos
if($_POST['nome'] == "" or $_POST['telefone'] == "" or $_POST['telefone'] == "" or $_POST['numero'] == "" or $_POST['bairro'] == "" or $_POST['cidade'] == "" or $_POST['estado'] == "" or $_POST['cep'] == "" or $_POST['complemento'] == ""){
    echo "erro";
}else{
    session_start();
    include'conecta.php';
    // Salvando dados da data e horario
    date_default_timezone_set('America/Sao_Paulo');
    $date = date('Y-m-d H:i');

    if($_POST['formPag'] == "pix"){
        $formPag = 'Pix';
    }else{
        $formPag = 'Cartão de Crédito/Débito';
    }

    // Consultando carrinho
    $id = $_SESSION['id'];
    $script_carrinho = $conn->prepare("SELECT * FROM tb_carrinho WHERE id_user = '$id'");
    $script_carrinho->execute();
    $text_produtos = "";
    $soma = 0;

    // While para calcular o valor dos produtos totais no carrinho
    while ($carrinho = $script_carrinho->fetch(PDO::FETCH_ASSOC)){
        $id_produto = $carrinho['id_produto'];
        $script_produtos = $conn->prepare("SELECT * FROM tb_products WHERE id='$id_produto'");
        $script_produtos->execute();
        $produto = $script_produtos->fetch(PDO::FETCH_ASSOC);
        $soma = $soma+$produto['vl_produto'];

        $text_produtos = $text_produtos.$produto['nm_produto']." - R$".$produto['vl_produto']."%0A";
    }
    $soma += 30;
    $npedido = str_replace('-', '', $date);
    $npedido = str_replace(':', '', $npedido);
    $npedido = str_replace(' ', '', $npedido);
    
    $text_link = "
    Confira o pedido:
    Pedido N ".$npedido." - Akame
    ---------------------------------------
    ".$text_produtos."
    Frete: R$30,00 até 10 dia(s) úteis
    Total: R$ ".$soma." 
    --------------------------------------- 

    Informações do cliente
    Nome: ".$_POST['nome']."
    Contato: ".$_POST['telefone']." 
    Pagamento: ".$formPag."

    Endereço de entrega:
    ".$_POST['rua'].", ".$_POST['numero']."
    ".$_POST['bairro']."
    ".$_POST['cidade']." /".$_POST['estado']."
    ".$_POST['estado']."
    ".$_POST['complemento']."

    Pedido gerado ".$date;
    $stringCorrigida = str_replace('
    ', '%0A', $text_link);
    $stringCorrigida = str_replace(' ', '%20', $stringCorrigida);

    echo "https://wa.me/5513996217238?text=".$stringCorrigida;
}
?>