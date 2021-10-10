<?php

function myAut(){
    if($_SESSION['userlogin']){
        $id      = $_SESSION['userlogin']['id'];
        $user    = $_SESSION['userlogin']['usuario'];
        $code    = $_SESSION['userlogin']['senha'];
        $readUser = read('administrador', "id='$id' AND usuario='$user' AND senha='$code'");
        if(!$readUser){
            unset($_SESSION['userlogin']);
            header('Location: index.php?restrito=true');
        }
    }else{
        header('Location: index.php?restrito=true');
    }
}