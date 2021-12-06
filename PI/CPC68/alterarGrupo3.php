<?php
session_start();
include_once 'src/Grupo.php';
include_once 'src/GrupoRepositorio.php';

use src\Grupo;
use src\GrupoRepositorio;

$Grupo = new Grupo();
$Grupo->setId($_POST['id']);
$Grupo->setNome($_POST['nome']);
$Grupo->setDescricao($_POST['descricao']);

$GrupoRepositorio = new GrupoRepositorio();
$retorno = $GrupoRepositorio->alterarGrupo($Grupo);

if ($retorno == TRUE) {
    $_SESSION['resultado'] = 0;
    header('Location: alterarGrupo2.php?nome=' . $_POST['nome']);
} else {
    $_SESSION['resultado'] = 1;
    header('Location: alterarGrupo2.php?nome=' . $_POST['nome']);
}
?>