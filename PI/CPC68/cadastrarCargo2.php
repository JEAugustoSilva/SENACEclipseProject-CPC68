<?php
session_start();
date_default_timezone_set('America/Sao_Paulo');
include_once 'src/Cargo.php';
include_once 'src/CargoRepositorio.php';

use src\Cargo;
use src\CargoRepositorio;

$Cargo = new Cargo();
$Cargo->setNome($_POST['nome']);
$Cargo->setDescricao($_POST['descricao']);
$CargoRepositorio = new CargoRepositorio();

$existe = $CargoRepositorio->existeCargo($Cargo);

if ($existe != TRUE) {
    $retorno = $CargoRepositorio->cadastrarCargo($Cargo);
    if ($retorno == TRUE) {
        $_SESSION['resultado'] = 0;
        header('Location: cadastrarCargo.php');
    } else {
        $_SESSION['resultado'] = 1;
        header('Location: cadastrarCargo.php');
    }
} else {
   $_SESSION['resultado'] = 3;
   header('Location: cadastrarCargo.php');
}
