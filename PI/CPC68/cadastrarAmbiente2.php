<?php
session_start();
date_default_timezone_set('America/Sao_Paulo');
include_once 'src/Ambiente.php';
include_once 'src/AmbienteRepositorio.php';
include_once 'src/Unidade.php';

use src\Ambiente;
use src\AmbienteRepositorio;
use src\Unidade;
    $Ambiente = new Ambiente();
    $Unidade = new Unidade();
    
    $Unidade->setId($_POST['idUnidade']);

    $Ambiente->setUnidade($Unidade);
    $Ambiente->setNome($_POST['nome']);
    $Ambiente->setDescricao($_POST['descricao']);
    $AmbienteRepositorio = new AmbienteRepositorio();
    
    $existe = $AmbienteRepositorio->existeAmbiente($Ambiente);
    
    if ($existe != TRUE) {
        $retorno = $AmbienteRepositorio->cadastrarAmbiente($Ambiente);
        if ($retorno == TRUE) {
            $_SESSION['resultado'] = 0;
            header('Location: cadastrarAmbiente.php');
        } else {
            $_SESSION['resultado'] = 1;
            header('Location: cadastrarAmbiente.php');
        }
    } else {
        $_SESSION['resultado'] = 3;
        header('Location: cadastrarAmbiente.php');
    }
    