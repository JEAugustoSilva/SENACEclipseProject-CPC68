<?php
session_start();

include_once 'src/Funcionario.php';
include_once 'src/FuncionarioRepositorio.php';

use src\Funcionario;
use src\FuncionarioRepositorio;

if ($_SERVER['HTTP_REFERER'] != "http://localhost/PI/CPC68/index.php" && $_SERVER['HTTP_REFERER'] != "http://localhost/pi/CPC68/" && $_SERVER['HTTP_REFERER'] != "http://localhost/pi/CPC68/index.php" && $_SERVER['HTTP_REFERER'] != "http://localhost/PI/CPC68/") {
    header('Location: index.php');
} else {
    $login = $_POST['login'];
    $senha = $_POST['senha'];

    $login = trim($login);
    $senha = trim($senha);

    if (strlen($login) > 25 || strlen($senha) > 25) {
        print "Quantidade de caracteres excedida em Usuário e/ou Senha.";
    } else {
        $Funcionario = new Funcionario();
        $Funcionario->setLogin($login);
        $Funcionario->setSenha($senha);

        $FuncionarioRepositorio = new FuncionarioRepositorio();
        $retorno = $FuncionarioRepositorio->validarLogin($Funcionario);

        if ($retorno == TRUE) {
            $Funcionario = $FuncionarioRepositorio->autenticarFuncionario($Funcionario);
            $_SESSION['resultado'] = -1;
            $_SESSION['logou'] = TRUE;
            $_SESSION['senha'] = TRUE;
            $_SESSION['id'] = $Funcionario->getId();
            $_SESSION['cargo'] = $Funcionario->getCargo()->getId();
            $_SESSION['unidade'] = $Funcionario->getUnidade()->getId();
            $_SESSION['nomeUnidade'] = $Funcionario->getUnidade()->getNome();
            $_SESSION['idAtorCadastro'] = $Funcionario->getIdAtorCadastro();
            $_SESSION['nome'] = $Funcionario->getNome();
            $_SESSION['turno'] = $Funcionario->getTurno();
            $_SESSION['nivel'] = $Funcionario->getNivel();
            $_SESSION['dtRegistro'] = $Funcionario->getDtRegistro();
            $_SESSION['login'] = $Funcionario->getLogin();
            $_SESSION['situacao'] = $Funcionario->getSituacao();
            header('Location: telaPrincipal.php');
        } else {
            $_SESSION['resultado'] = 1;
            header('Location: index.php');
        }
    }
}
