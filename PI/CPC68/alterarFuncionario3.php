<?php
session_start();
include_once 'src/Cargo.php';
include_once 'src/Unidade.php';
include_once 'src/Funcionario.php';
include_once 'src/FuncionarioRepositorio.php';

use src\Funcionario;
use src\Cargo;
use src\Unidade;
use src\FuncionarioRepositorio;

$Funcionario = new Funcionario();
$Funcionario->setId($_POST['id']);

$Cargo = new Cargo();
$Cargo->setId($_POST['idCargo']);
$Funcionario->setCargo($Cargo);

$CargoSuperior = new Cargo();
$CargoSuperior->setId($_POST['idCargoSuperior']);
$Funcionario->setCargoSuperior($CargoSuperior);

$Unidade = new Unidade();
$Unidade->setId($_POST['idUnidade']);
$Funcionario->setUnidade($Unidade);

$Funcionario->setIdAtorCadastro($_POST['idAtorCadastro']);
$Funcionario->setNome($_POST['nome']);
$Funcionario->setEmail($_POST['email']);
$Funcionario->setTelefone($_POST['telefone']);
$Funcionario->setTurno($_POST['turno']);
$Funcionario->setNivel($_POST['nivel']);

$FuncionarioRepositorio = new FuncionarioRepositorio();
$retorno = $FuncionarioRepositorio->alterarFuncionario($Funcionario);

if ($retorno == TRUE) {
    $_SESSION['resultado'] = 0;
    header('Location: alterarFuncionario2.php?pesquisa=' . $_POST['nome']);
} else {
    $_SESSION['resultado'] = 1;
    header('Location: alterarFuncionario2.php?pesquisa=' . $_POST['nome']);
}