<?php
session_start();
date_default_timezone_set('America/Sao_Paulo');
use src\Subgrupo;
use src\Grupo;
use src\SubgrupoRepositorio;

include_once 'src/Subgrupo.php';
include_once 'src/SubgrupoRepositorio.php';
include_once 'src/Grupo.php';

$Subgrupo = new Subgrupo();
$Grupo = new Grupo();
$Grupo->setId($_POST['idGrupo']);
$Subgrupo->setGrupo($Grupo);
$Subgrupo->setNome($_POST['nome']);
$Subgrupo->setDescricao($_POST['descricao']);
$SubgrupoRepositorio = new SubgrupoRepositorio();

$existe = $SubgrupoRepositorio->existeSubgrupo($Subgrupo);
if ($existe != TRUE) {
    $retorno = $SubgrupoRepositorio->cadastrarSubgrupo($Subgrupo);
    if ($retorno == TRUE) {
        $_SESSION['resultado'] = 0;
        header('Location: cadastrarSubgrupo.php');
    } else {
        $_SESSION['resultado'] = 1;
        header('Location: cadastrarSubgrupo.php');
    }
} else {
    $_SESSION['resultado'] = 3;
    header('Location: cadastrarSubgrupo.php');
}
