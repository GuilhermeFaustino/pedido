<?php
/* * *************************** */
/* Url Amigavel */
/* * *************************** */

    function setHome(){
        echo BASE;
    }
/* * *************************** */
/* Inclui Arquivos */
/* * *************************** */
    
function setArq($arquivo){
    
    if(file_exists($arquivo.'.php')){
        include ($arquivo.'.php');
    }else{
        echo 'Não foi possivel incluiro arquivo '.$arquivo.'.php';
    }
}
    


/* * *************************** */
/* Url Amigavel */
/* * *************************** */
function setUrl($string) {
    $a = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜüÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ"!@#$%&*()_-+={[}]/?;:.,\\\'<>°ºª';
    $b = 'aaaaaaaceeeeiiiidnoooooouuuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr                                 ';
    $string = utf8_decode($string);
    $string = strtr($string, utf8_decode($a), $b);
    $string = strip_tags(trim($string));
    $string = str_replace(" ", "-", $string);
    $string = str_replace(array("-----", "----", "--"), "-", $string);
    $string = strtolower(utf8_encode($string));
    return $string;
}

/* * *************************** */
/* setViews */
/* * *************************** */


function setViews($topicoId) {
    $conn = connect();
    $topicoId = mysqli_real_escape_string($conn, $topicoId);
    $readArtigo = read('up_posts',"WHERE id = '$topicoId'");

    foreach ($readArtigo as $redArt);
        $views = $redArt['visitas'];
        $views = $views +1;
        $dataViwes = array(
            'visitas' => $views
        );
        
        update('up_posts', $dataViwes, "id = '$topicoId'");
        
}

?>
