<?php
session_start();

include_once 'src/Grupo.php';
include_once 'src/Subgrupo.php';
include_once 'src/SubgrupoRepositorio.php';

use src\Subgrupo;
use src\Grupo;
use src\SubgrupoRepositorio;

$Subgrupo = new Subgrupo();
$Subgrupo->setId($_POST['id']);
$Subgrupo->setNome($_POST['nome']);
$Subgrupo->setDescricao($_POST['descricao']);

$Grupo = new Grupo();
$Grupo->setId($_POST['idGrupo']);
$Subgrupo->setGrupo($Grupo);

$SubgrupoRepositorio = new SubgrupoRepositorio();
$retorno = $SubgrupoRepositorio->alterarSubgrupo($Subgrupo);

if ($retorno == TRUE) {
    $_SESSION['resultado'] = 0;
    header('Location: alterarSubgrupo2.php?pesquisa=' . $_POST['nome']);
} else {
    $_SESSION['resultado'] = 1;
    header('Location: alterarSubgrupo2.php?pesquisa=' . $_POST['nome']);
}