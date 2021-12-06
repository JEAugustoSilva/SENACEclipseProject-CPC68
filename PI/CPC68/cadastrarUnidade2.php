<?php 
session_start();
date_default_timezone_set('America/Sao_Paulo');
include_once 'src/Unidade.php';
include_once 'src/UnidadeRepositorio.php';

use src\Unidade;
use src\UnidadeRepositorio;

$Unidade = new Unidade();
$Unidade->setNome($_POST['nome']);
$Unidade->setSigla($_POST['sigla']);
$Unidade->setEndereco($_POST['endereco']);
$UnidadeRepositorio = new UnidadeRepositorio();

$existe = $UnidadeRepositorio->existeUnidade($Unidade);

if ($existe != TRUE) {
    $retorno = $UnidadeRepositorio->cadastrarUnidade($Unidade);
    if ($retorno == TRUE) {
        $_SESSION['resultado'] = 0;
        header('Location: cadastrarUnidade.php');
    } else {
        $_SESSION['resultado'] = 1;
        header('Location: cadastrarUnidade.php');
    }
} else {
    $_SESSION['resultado'] = 3;
    header('Location: cadastrarUnidade.php');
}

