<?php
session_start();
date_default_timezone_set('America/Sao_Paulo');
include_once 'src/Grupo.php';
include_once 'src/GrupoRepositorio.php';

use src\Grupo;
use src\GrupoRepositorio;

$Grupo = new Grupo();
$Grupo->setNome($_POST['nome']);
$Grupo->setDescricao($_POST['descricao']);
$GrupoRepositorio = new GrupoRepositorio();

$existe = $GrupoRepositorio->existeGrupo($Grupo);

if ($existe != TRUE) {
    $retorno = $GrupoRepositorio->cadastrarGrupo($Grupo);
    if ($retorno == TRUE) {
        $_SESSION['resultado'] = 0;
        header('Location: cadastrarGrupo.php');
    } else {
        $_SESSION['resultado'] = 1;
        header('Location: cadastrarGrupo.php');
    }
} else {
    $_SESSION['resultado'] = 3;
    header('Location: cadastrarGrupo.php');
}
