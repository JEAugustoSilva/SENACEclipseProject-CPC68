<?php
session_start();
include_once 'src/Cargo.php'; 
include_once 'src/CargoRepositorio.php';

use src\Cargo;
use src\CargoRepositorio;

$Cargo = new Cargo();
$Cargo->setId($_POST['id']);
$Cargo->setNome($_POST['nome']);
$Cargo->setDescricao($_POST['descricao']);

$CargoRepositorio = new CargoRepositorio();
$retorno = $CargoRepositorio->alterarCargo($Cargo);

if ($retorno == TRUE) {
    $_SESSION['resultado'] = 0;
    header("Location: alterarCargo2.php?nome=" . $Cargo->getNome());
} else {
    $_SESSION['resultado'] = 1;
    header("Location: alterarCargo2.php?nome=" . $Cargo->getNome());
}