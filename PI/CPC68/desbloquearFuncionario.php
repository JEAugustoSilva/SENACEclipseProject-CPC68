<?php
use src\Funcionario;
use src\FuncionarioRepositorio;

session_start();

include_once 'src/Funcionario.php';
include_once 'src/FuncionarioRepositorio.php';
?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>CPC68</title>
<link rel="stylesheet" href="style.css"> <link rel="icon" type="image/png" href="favicon.png"> <script src="jquery-3.3.1.js"></script>
</head>
<body>
<?php
    $Funcionario = new Funcionario();
    $Funcionario->setId($_GET['id']);
    $Funcionario->setNome($_GET['nome']);
    $FuncionarioRepositorio = new FuncionarioRepositorio();
    $retorno = $FuncionarioRepositorio->desbloquearFuncionario($Funcionario);

    if ($retorno == TRUE) {
        header('Location: consultarFuncionario2.php?pesquisa=' . $Funcionario->getNome());
    } else {
        echo "Falha no desbloqueio!";
        echo "<a href='consultarFuncionario2.php?pesquisa=" . $Funcionario->getNome() . "'>Voltar</a>";
    }
?>
</body>
</html>