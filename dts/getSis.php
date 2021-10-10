<?php

/* * ************** */
/* * *****GET HOME** */
/* * ************** */

function getHome() {
    @$url = $_GET['url'];
    @$url = explode('/', $url);
    @$url[1] = ($url[1] == NULL ? 'index' : $url[1]);
    if (file_exists('Themes/' . $url[0] . '.php')) {
        @require_once('Themes/' . $url[1] . '.php');
    } elseif (file_exists('Themes/' . $url[0] . '/' . $url[1] . '.php')) {
        require_once('Themes/' . $url[0] . '/' . $url[1] . '.php');
    } else {
        require_once('Themes/404.php');
    }
}

/* * ************** */
/* * *****GET HOME** */
/* * ************** */

function getThumb($img, $titulo, $alt, $w, $h, $grupo = null, $dir = null, $link = NULL) {

    $grupo = ($grupo != null ? "[$grupo]" : "");
    $dir = ($dir != null ? "$dir" : "uploads");

    $verDir = explode('/', $_SERVER['PHP_SELF']);
    $urlDir = (in_array('clientes', $verDir) ? '../' : '');

    if (file_exists($urlDir . $dir . '/' . $img)) {

        if ($link == '') {
            echo '<a href = "' . BASE . '/' . $dir . '/' . $img . '" rel="Shadowbox' . $grupo . '" alt="' . $alt . '" title="' . $titulo . '">  
                    <img src="' . BASE . '/tim.php?src=' . BASE . '/' . $dir . '/' . $img . '&w=' . $w . '&h=' . $h . '&cz=1q=100"
                    title="' . $titulo . '" alt="' . $alt . '">
                    </a > 
                 ';
        } elseif ($link == '#') {
            echo '  
                    <img src="' . BASE . '/tim.php?src=' . BASE . '/' . $dir . '/' . $img . '&w=' . $w . '&h=' . $h . '&cz=1q=100"
                    title="' . $titulo . '" alt="' . $alt . '">
                    
                 ';
        } else {
            echo '<a href = "' . $link . '" title="' . $titulo . '">  
                    <img src="' . BASE . '/tim.php?src=' . BASE . '/' . $dir . '/' . $img . '&w=' . $w . '&h=' . $h . '&cz=1q=100"
                    title="' . $titulo . '" alt="' . $alt . '">
                    </a > 
                 ';
        }
    } else {
        echo '  
                    <img src="' . BASE . '/tim.php?src=' . BASE . '/imagens/default.jpg&w=' . $w . '&h=' . $h . '&cz=1q=100"
                    title="' . $titulo . '" alt="' . $alt . '">
                    
                 ';
    }
}

/* * ************** */
/* * *****GET CAT** */
/* * ************** */

function getCat($catId, $campo = NULL) {
    $conn = connect();
    $categoria = mysqli_real_escape_string($conn, $catId);
    $redCategoria = read('up_cat', "WHERE id = '$categoria'");
    if ($redCategoria) {

        if ($campo) {
            foreach ($redCategoria as $cat) {
                return $cat[$campo];
            }
        } else {

            return $redCategoria;
        }
    } else {
        return 'errro ao ler Categoria';
    }
}

/* * ************** */
/* * *****GET AUTHOR** */
/* * ************** */

function getAuthor($autorId, $campo = NULL) {

    $conn = connect();
    $autorId = mysqli_real_escape_string($conn, $autorId);
    $readAuthor = read('up_users', "WHERE id = '$autorId'");

    if ($readAuthor):
        foreach ($readAuthor as $autor):

            if (!$autor['foto']):
                $gravatar = "https://www.gravatar.com/avatar/";
                $gravatar .= md5(strtolower(trim($autor[$email])));
                $gravatar .= '?d=mm&s=180';

                $autor['foto'] = $gravatar;

            endif;

            return $autor;
        endforeach;

    else:
        echo 'Erro ao ler Autor';

    endif;
}

/* * ************** */
/* * *****Paginator** */
/* * ************** */

function readPaginator($tabela, $cond, $maximos, $link, $pag, $width = NULL, $maxlinks = 2) {
    $readPaginator = read("$tabela", "$cond");
    $total = count($readPaginator);
    if ($total > $maximos) {
        $paginas = ceil($total / $maximos);
        if ($width) {
            echo '<div class="card-footer" style="width:' . $width . '">';
        } else {
            echo '<div class="card-footer">';
            echo '<ul class="pagination pagination-sm m-0 float-right">';
        }
        echo '<li class="page-item"><a class="page-link" href="' . $link . '1">«</a></li>';
        for ($i = $pag - $maxlinks; $i <= $pag - 1; $i++) {
            if ($i >= 1) {
                echo '<li class="page-item"><a class="page-link" href="' . $link . $i . '">' . $i . '</a></li>';
            }
        }
        echo '<li class="page-link">' . $pag . '</li>';
        for ($i = $pag + 1; $i <= $pag + $maxlinks; $i++) {
            if ($i <= $paginas) {
                echo '<li class="page-item"><a class="page-link" href="' . $link . $i . '">' . $i . '</a></li>';
            }
        }
              echo '<li class="page-item"><a class="page-link" href="' . $link . $paginas . '">»</a></li>';
            echo '</ul>';
          echo '</div><!-- /paginator -->';
    }
}

/* * ************** */
/* * *****GET AUTHOR** */
/* * ************** */

function getUser($user, $nivel = null) {

    if ($nivel != NULL) {
        $readUser = @read('k_user', "WHERE id = '$user'");
        if ($readUser) {
            foreach ($readUser as $usuario);
            if ($usuario['k_nivel'] <= $nivel && $usuario['k_nivel'] != '0' && $usuario['k_nivel'] <= '4') {
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            return false;
        }
    } else {
        return FALSE;
    }
}

?>