<?php
use src\Funcionario;
use src\Ativo;
use src\Subgrupo;
use src\Ambiente;
use src\AtivoRepositorio;

session_start();
date_default_timezone_set('America/Sao_Paulo');
include_once 'src/Ativo.php';
include_once 'src/AtivoRepositorio.php';
include_once 'src/Subgrupo.php';
include_once 'src/Ambiente.php';
include_once 'src/Funcionario.php';

$Ativo = new Ativo();

$Subgrupo = new Subgrupo();
$Subgrupo->setId($_POST['idSubgrupo']);
$Ativo->setSubgrupo($Subgrupo);

$Ambiente = new Ambiente();
$Ambiente->setId($_POST['idAmbiente']);
$Ativo->setAmbiente($Ambiente);

$Funcionario = new Funcionario();
$Funcionario->setId($_POST['idFuncionario']);
$Ativo->setFuncionario($Funcionario);

$Ativo->setNome($_POST['nome']);
$Ativo->setDescricao($_POST['descricao']);
$Ativo->setCodigoBarra($_POST['codigoBarra']);

$AtivoRepositorio = new AtivoRepositorio();
$existe = $AtivoRepositorio->existeAtivo($Ativo);

if ($existe != true) {
    $retorno = $AtivoRepositorio->cadastrarAtivo($Ativo);
    if ($retorno == true) {
        $_SESSION['resultado'] = 0;
        header('Location: cadastrarAtivo2.php?idUnidade=' . $_POST['idUnidade'] . '');
    } else {
        $_SESSION['resultado'] = 1;
        header('Location: cadastrarAtivo2.php?idUnidade=' . $_POST['idUnidade'] . '');
    }
} else {
    $_SESSION['resultado'] = 3;
    header('Location: cadastrarAtivo2.php?idUnidade=' . $_POST['idUnidade'] . '');
}