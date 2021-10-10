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
    <form name="formCafe" action="" method="post">
        <h1 class="text-center">Cafe da Manha</h1></br></br> <a href="index.php"><input class="btnalt" type="button" value="Voltar" name="limpar"></a></br></br>
        <br>
        <?php
            require 'dts/config.php';
            if(filter_input(INPUT_GET, 'id', FILTER_SANITIZE_SPECIAL_CHARS)){
                $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_SPECIAL_CHARS);
                $readUpdate = read('pedido', "id='$id'");
               foreach ($readUpdate as $update){
                   echo '<label class="label" for="fname">Digite seu Nome:</label><br>';
                   echo '<input class="check" type="text" id="" name="fname" value="'.$update['nome'].'"><br></br>';
                   echo ' <label class="label" for="lname">Digite seu Cpf:</label><br>';
                   echo ' <input type="text" name="fcpf" value="'.$update['cpf'].'"></br></br>';
                   echo '<label class="label" for="lname">Qual produto para o cafe?</label><br>';
                   echo '<input class="label" type="text" value="'.$update['cafe'].'"name="cafe"></br></br>';
                   echo '<input class="btn" type="submit" value="Enviar" name="editarDados">';
               }
            }

        ?>
    </form>
        <?php
        if (filter_input(INPUT_POST, 'editarDados', FILTER_SANITIZE_SPECIAL_CHARS)){
            $c['id']   = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_SPECIAL_CHARS);
            $c['nome'] = filter_input(INPUT_POST, 'fname', FILTER_SANITIZE_SPECIAL_CHARS);
            $c['cpf']  = filter_input(INPUT_POST, 'fcpf', FILTER_SANITIZE_SPECIAL_CHARS);
            $c['cafe']  = filter_input(INPUT_POST, 'cafe', FILTER_SANITIZE_SPECIAL_CHARS);
            $c['data'] = date("Y-m-d H:i:s");
            if(in_array('', $c)){
                echo '<span class="ms al">ops existem campos em brancos</span>';
            }else{
                $readPedido = update('pedido', $c, "id='$c[id]'");
                echo '<span class="ms in">Aeee Cafe Alterado Com sucesso. <a href="index.php"><input class="btnalt" type="button" value="Voltar" name="limpar"></a></span>';
            }
        }
    ?>
</div>
</body>
</html>
