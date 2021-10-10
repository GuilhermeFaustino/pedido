
<!DOCTYPE html>
<html lang="">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Guilherme Mendes</title>

    <link rel="stylesheet" type="text/css" href="css/painel.css" />
    <link rel="stylesheet" type="text/css" href="css/geral.css" />

    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.3/html5shiv.js"></script>
</head>
<body>
<div id="painel">

    <div id="header">
        <h1 class="text-center">Cafe da Manha</h1>

    </br>
    <form name="formCafe" action="" method="post">
        <?php
        require 'dts/config.php';
            if (filter_input(INPUT_GET, 'id', FILTER_SANITIZE_SPECIAL_CHARS)) {
                $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_SPECIAL_CHARS);
                $del = delete('pedido', "id='$id'");
                if($del){
                    echo '<span class="ms no">Pedido Deletado com sucesso.<a href="index.php"><input class="btnalt" type="button" value="Voltar" name="limpar"></a></span></br>';
                }
            }
        ?>
        </br></br>
            <label class="label" for="fname">Digite seu Nome:</label><br>
            <input class="check" type="text" id="" name="fname"><br></br>
            <label class="label" for="lname">Digite seu Cpf:</label><br>
            <input type="text" name="fcpf"></br></br>
            <label class="label" for="lname">Qual produto para o cafe?</label><br>
            <input class="label" type="text" name="cafe"></br></br>
            <input class="btn" type="submit" value="Enviar" name="eviarDados">
            <input class="btnalt" type="reset" value="Limpar" name="limpar"></br></br>
    </form>
        <?php

        if (filter_input(INPUT_POST, 'eviarDados', FILTER_SANITIZE_SPECIAL_CHARS)){
            $c['nome'] = filter_input(INPUT_POST, 'fname', FILTER_SANITIZE_SPECIAL_CHARS);
            $c['cpf']  = filter_input(INPUT_POST, 'fcpf', FILTER_SANITIZE_SPECIAL_CHARS);
            $c['cafe']  = filter_input(INPUT_POST, 'cafe', FILTER_SANITIZE_SPECIAL_CHARS);
            $c['data'] = date("Y-m-d H:i:s");

            if(in_array('', $c)){
                echo '<span class="ms al">ops existem campos em brancos</span>';
            }else{
                $readPedido = read('pedido', "cpf='$c[cpf]'");
                if($readPedido){
                    echo '<span class="ms in">Ops.. Cpf já Cadastrado.</span>';
                }elseif($readPedido = read('pedido', "cafe='$c[cafe]'")){
                    echo '<span class="ms in">Ops.. Cafe ja Foi escolhido.</span>';
                }else{
                    $readcafe = create("pedido",$c);
                    echo '<span class="ms in">Cadastro Realizado com Sucesso</span>';
                }
            }

        }
        ?>
        <table width="560" border="0" id="customers" style="float:left;" cellspacing="0" cellpadding="0">
            <tr class="ses">
                <td>#id</td>
                <td>Nome</td>
                <td align="center">Cpf</td>
                <td align="center">Data Criação:</td>
                <td align="center" colspan="3">ações:</td>
            </tr>
            <?php
                $readPedido = read('pedido', "id > 0");
                foreach ($readPedido as $pedido){
                    echo '<tr>';
                        echo '<td>'.$pedido['id'].'</td>';
                        echo '<td>'.$pedido['nome'].'</td>';
                        echo '<td align="center">'.$pedido['cpf'].'</td>';
                        echo '<td align="center">'.$pedido['data'].'</td>';
                        echo '<td align="center"><a href="edit.php?&id='.$pedido['id'].'" title="editar"><img src="ico/edit.png" alt="editar" title="editar" /></a></td>';
                        echo '<td align="center"><a href="index.php?&id='.$pedido['id'].'" title="editar"><img src="ico/no.png" alt="editar" title="excluir" /></a></td>';
                    echo '</tr>';
                }
            ?>
        </table>
    </div><!-- /bloco user -->
</div>
</body>
</html>
