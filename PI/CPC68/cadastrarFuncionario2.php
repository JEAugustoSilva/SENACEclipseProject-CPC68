<?php
session_start();
date_default_timezone_set('America/Sao_Paulo');
include_once 'src/Funcionario.php';
include_once 'src/FuncionarioRepositorio.php';
include_once 'src/Cargo.php';
include_once 'src/Unidade.php';


use src\Funcionario;
use src\FuncionarioRepositorio;
use src\Cargo;
use src\Unidade;

$Funcionario = new Funcionario();
$Funcionario->setIdAtorCadastro($_POST['idAtorCadastro']);
$Cargo = new Cargo();
$Cargo->setId($_POST['idCargo']);
$Funcionario->setCargo($Cargo);
$CargoSuperior = new Cargo();
$CargoSuperior->setId($_POST['idCargoSuperior']);
$Funcionario->setCargoSuperior($CargoSuperior);
$Unidade = new Unidade();
$Unidade->setId($_POST['idUnidade']);
$Funcionario->setUnidade($Unidade);
$Funcionario->setNome($_POST['nome']);
$Funcionario->setEmail($_POST['email']);
$Funcionario->setTelefone($_POST['telefone']);
$Funcionario->setTurno($_POST['turno']);
$Funcionario->setNivel($_POST['nivel']);
$Funcionario->setLogin($_POST['login']);
$Funcionario->setSenha($_POST['senha']);
$FuncionarioRepositorio = new FuncionarioRepositorio();

$existe = $FuncionarioRepositorio->existeFuncionario($Funcionario);
if ($existe != true) {
    $retorno = $FuncionarioRepositorio->cadastrarFuncionario($Funcionario);
    if ($retorno == true) {
        $_SESSION['resultado'] = 0;
        header('Location: cadastrarFuncionario.php');
    } else {
        $_SESSION['resultado'] = 1;
        header('Location: cadastrarFuncionario.php');
    }
} else {
    $_SESSION['resultado'] = 3;
    header('Location: cadastrarFuncionario.php');
}
