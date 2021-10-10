<?php

function dateOut($date){
    $dataOut = date('d-m-Y H:i:s', strtotime($date));
    return $dataOut;
}


function formvalor($date){
    $result = str_replace([','], '.', $date);
    return $result;
}

function barra($date){
    $result = str_replace(['../'], '', $date);
    return $result;
}

function limpaCPF_CNPJ($valor){
    $valor = preg_replace('/[^0-9]/', '', $valor);
    return $valor;
}




/* * ******************************* */
/* * *****FORM DATE****** */
/* * ***************************** */
function dateCadastro($data) {
    $timestamp = explode(" ", $data);
    $getData = $timestamp[0];
    @$getTime = $timestamp[1];

    $setData = explode('/', $getData);

    $dia = $setData[0];
    $mes = $setData[1];
    $ano = $setData[2];
    if (!$getTime):
        $getTime = date('H:i:s');
    endif;
    $resultado = $dia . '-' . $mes . '-' . $ano . ' '.$getTime;
return $resultado;
}


/* * ******************************* */
/* * *****lmwords Palavars****** */
/* * ***************************** */

function lmwords($texto, $limite) {
    $contador = strlen($texto);
    if ($contador >= $limite) {
        $texto = substr($texto, 0, strrpos(substr($texto, 0, $limite), ' ')) . '...';
        return $texto;
    } else {
        return $texto;
    }
}

function is_email(string $email): bool
{
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

/* * ******************************* */
/* * *****Envio de Email****** */
/* * ***************************** */

function sendMail($assuntoEmail, $mensagem, $remetente, $nomeRemetente, $destino, $nomeDestino = NULL, $reply = NULL, $replyNome = NULL) {

    require_once('mail/class.phpmailer.php'); //Include pasta/classe do PHPMailer

    $mail = new PHPMailer(true); //INICIA A CLASSE
    $mail->IsSMTP();
    try {
        $mail = new PHPMailer(true);

        //CONFIG
        $mail->isSMTP();
        $mail->setLanguage("br");
        $mail->isHTML(true);
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'tls';
        $mail->CharSet = 'utf-8';

        //AUTH
        $mail->Host = "smtp.sendgrid.net";
        $mail->Username = "apikey";
        $mail->Password = "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";
        $mail->Port = "587";


        //MAIL
        $mail->setFrom("guilhermemendes.info@gmail.com", $nomeRemetente);
        $mail->Subject = $assuntoEmail;
        $mail->msgHTML($mensagem);

        //SEND->
        $mail->addAddress($destino, $nomeDestino);
        $send = $mail->send();

    } catch (phpmailerException $e) {
        echo $e->errorMessage(); //Mensagem de erro costumizada do PHPMailer
    }
}

/* * ******************************* */
/* * *****Manager****** */
/* * ***************************** */
function viewManager($times = 2){
		$selMes = date('m');
		$selAno = date('Y');                
                if(empty($_SESSION['startView']['sessao'])){
			$_SESSION['startView']['sessao'] = session_id();
			$_SESSION['startView']['ip'] = $_SERVER['REMOTE_ADDR'];
			$_SESSION['startView']['url'] = $_SERVER['PHP_SELF'];
			$_SESSION['startView']['time_end'] = time() + $times;
			create('views_online',$_SESSION['startView']);
                       
                        $readViews = read('views',"WHERE mes = '$selMes' AND ano = '$selAno'",MYSQLI_ASSOC);
                        $resulCat = mysqli_num_rows($readViews);
                        //var_dump($resulCat);
                        if(!$resulCat){
                            $createViews = array('mes' => $selMes, 'ano' => $selAno, 'visitas'=> '1');   
                            //var_dump($createViews);
                            create('views',$createViews);
                        }else{
                            foreach($readViews as $views);
                            //var_dump($views);
                            if(empty($_COOKIE['startView'])){
                                $updateViwes = array(
                                  'visitas'=> $views['visitas']+1,  
                                  'visitantes'=> $views['visitantes']+1,
                                );
                                update('views',$updateViwes,"mes = '$selMes' AND ano = '$selAno'");
                                setcookie('startView',time(),time()+60*60*24,'/');
                            }else{
                                $updateVisitas = array('visitas' => $views['visitas']+1);
                                update('views', $updateVisitas,"mes = '$selMes' AND ano = '$selAno'");
                            }
                        }                        
                }else{ 
                    $readPageViews = read('views',"WHERE mes = '$selMes' AND ano = '$selAno'");
			if($readPageViews){
				foreach($readPageViews as $rpgv);
				$updatePageViews = array('pageviews' => $rpgv['pageviews']+1);
				update('views',$updatePageViews,"mes = '$selMes' AND ano = '$selAno'");
			}
                    $id_sessao = $_SESSION['startView']['sessao'];
                    if($_SESSION['startView']['time_end'] <= time()){
                        delete('views_online',"sessao = '$id_sessao' OR time_end <= time(NOW())");
                        unset($_SESSION['startView']);
                    }else{
                        $_SESSION['startView']['time_end'] = time() + $times;
                        $timeEnd = array('time_end' =>$_SESSION['startView']['time_end']);
                        update('views_online', $timeEnd,"sessao = '$id_sessao'");
                    }
                }
}

/* * ***************************
  IMAGE UPLOAD
 * *************************** */

function uploadImage($tmp, $nome, $width, $pasta) {
    $ext = substr($nome, -3);
    switch ($ext) {
        case 'jpg': $img = ImageCreateFromJpeg($tmp);
            break;
        case 'png': $img = ImageCreateFromPng($tmp);
            break;
        case 'gif': $img = ImageCreateFromGif($tmp);
            break;
    }
    $x = imagesx($img);
    $y = imagesy($img);
    $height = ($width * $y) / $x;
    $nova = imagecreatetruecolor($width, $height);

    imagealphablending($nova, false);
    imagesavealpha($nova, true);
    imagecopyresampled($nova, $img, 0, 0, 0, 0, $width, $height, $x, $y);

    switch ($ext) {
        case 'jpg': imagejpeg($nova, $pasta.$nome, 100); break;
        case 'png': imagepng($nova, $pasta.$nome); break;
        case 'png': imagegif($nova, $pasta.$nome); break;
    }
    imagedestroy($img);
    imagedestroy($nova);
}


function filter(array $data)
    {
        $filter = [];
        foreach ($data as $key => $value) {
            $filter[$key] = (is_null($value) ? null : filter_var($value, FILTER_SANITIZE_SPECIAL_CHARS));
        }
        return $filter;
    }



function validaCPF($cpf) {

    // Extrai somente os números
    $cpf = preg_replace( '/[^0-9]/is', '', $cpf );

    // Verifica se foi informado todos os digitos corretamente
    if (strlen($cpf) != 11) {
        return false;
    }

    // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
    if (preg_match('/(\d)\1{10}/', $cpf)) {
        return false;
    }

    // Faz o calculo para validar o CPF
    for ($t = 9; $t < 11; $t++) {
        for ($d = 0, $c = 0; $c < $t; $c++) {
            $d += $cpf[$c] * (($t + 1) - $c);
        }
        $d = ((10 * $d) % 11) % 10;
        if ($cpf[$c] != $d) {
            return false;
        }
    }
    return true;

}


function valcelular($telefone){
    //$telefone= trim(str_replace('/', '', str_replace(' ', '', str_replace('-', '', str_replace(')', '', str_replace('(', '', $telefone))))));

    //$regexTelefone = "^[0-9]{11}$";
    $regexCel = '/[0-9]{2}[6789][0-9]{3,4}[0-9]{4}/'; // Regex para validar somente celular
    if (preg_match($regexCel, $telefone)) {
        return true;
    }else{
        return false;
    }
}


function phoneValidate($phone)
{
    $regex = '/^(?:(?:\+|00)?(55)\s?)?(?:\(?([1-9][0-9])\)?\s?)?(?:((?:9\d|[2-9])\d{3})\-?(\d{4}))$/';

    if (preg_match($regex, $phone) == false) {

        // O número não foi validado.
        return false;
    } else {

        // Telefone válido.
        return true;
    }
}

?>
