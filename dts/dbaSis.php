<?php

//require __DIR__."/config.php";
/* * ******************************* */
/* * *****Conexao Com o Banco****** */
/* * ***************************** */

function connect() {
    try{
        $pdo = new PDO("mysql:dbname=".DBSA.";host=".HOST.";charset=utf8",USER, PASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    }catch (PDOException $exception){
            echo "Erro ao conectar com banco de dados". $exception;
    }


}

/* * ******************************* */
/* * *****Cadastra no Banco****** */
/* * ***************************** */
function create($tabela, array $dados) {
    $pdo = connect();
    try{

        $keys = implode(", ", array_keys($dados));
        $values = "'" . implode("', '", array_values($dados)) . "'";
        $res = $pdo->prepare("INSERT INTO {$tabela} ({$keys}) VALUES ({$values})");
        $res->execute(filter($dados));
        return null;

    }catch(PDOException $exception){
        echo "Erro ao Cadastrar no banco de Dados".$exception;
    }
}


/* * ******************************* */
/* * *****ler o Banco****** */
/* * ***************************** */

function read($tabela, $cond = NUll) {
    $pdo = connect();
    try{
        $qrRead = $pdo->query("SELECT * FROM {$tabela} WHERE {$cond}");
        $readExe = $qrRead->fetchAll(PDO::FETCH_ASSOC);
        if ($cond) {
            parse_str($cond, $cond);
            foreach ($cond as $key => $value) {
                if($key == 'limit' || $key == 'offset'){
                    $qrRead->bindValue(":{$key}", $value, PDO::PARAM_INT);
                }else{
                    $qrRead->bindValue(":{$key}", $value, PDO::PARAM_STR);
                }
            }
        }
        $qrRead->execute();
        if($readExe){
            return $readExe;
        }else{
            return false;
        }
    }catch (PDOException $exception){
        echo "Erro ao ler Banco".$exception->getMessage();
    }
}

function readALL($tabela, $cond = NUll) {
    $pdo = connect();
    try{
        $qrRead = $pdo->query("SELECT * FROM {$tabela} WHERE {$cond}");
        $readExe = $qrRead->fetch(PDO::FETCH_ASSOC);
        if ($cond) {
            parse_str($cond, $cond);
            foreach ($cond as $key => $value) {
                if($key == 'limit' || $key == 'offset'){
                    $qrRead->bindValue(":{$key}", $value, PDO::PARAM_INT);
                }else{
                    $qrRead->bindValue(":{$key}", $value, PDO::PARAM_STR);
                }
            }
        }
        $qrRead->execute();
        if($readExe){
            return $readExe;
        }else{
            return false;
        }
    }catch (PDOException $exception){
        echo "Erro ao ler Banco ". $exception->getMessage();
    }
}

/* * ******************************* */
/* * *****Atualizar Banco****** */
/* * ***************************** */

function update($tabela, array $datas, $where) {
    $pdo = connect();
    try{
        $dateSet = [];
        foreach ($datas as $fildes => $values) {
            $dateSet[] = "$fildes = '$values'";
        }
        $dateSet = implode(", ", $dateSet);
        $update = $pdo->prepare("UPDATE {$tabela} SET {$dateSet} WHERE {$where}");
        $update->execute();
        if($update){
            return true;
        }else{
            return false;
        }
    }catch (PDOException $exception){
        echo "Erro ao realizar Update no Banco".$exception->getMessage();
    }
}


/* * ******************************* */
/* * *****Deletar Banco****** */
/* * ***************************** */

function delete($tabela, $where) {
    $pdo = connect();
    try{
        $stmt = $pdo->prepare("DELETE FROM {$tabela} WHERE {$where}");
        $stmt->execute();
        if($stmt){
            return true;
        }else{
            return false;
        }
    }catch (PDOException $exception){
        echo "Erro ao Deletar no Banco".$exception->getMessage();
    }

}


?>