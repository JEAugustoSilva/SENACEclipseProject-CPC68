<?php
session_start();

include_once 'src/Cargo.php';
include_once 'src/CargoRepositorio.php';

use src\Cargo;
use src\CargoRepositorio;
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>CPC68</title>
<link rel="stylesheet" href="style.css"> <link rel="icon" type="image/png" href="favicon.png"> <script src="jquery-3.3.1.js"></script>
</head>
<body>
<?php 
    $Cargo = new Cargo();
    $Cargo->setId($_GET['id']);
    $Cargo->setNome($_GET['nome']);
    
    $CargoRepositorio = new CargoRepositorio();
    $retorno = $CargoRepositorio->excluirCargo($Cargo);
    
    if ($retorno == TRUE) {
        header('Location: consultarCargo.php');
    } else {
        echo "<a href='consultarGrupo2.php?nome=" . $Cargo->getNome() . "'>Voltar</a>";
    }

?>
</body>
</html>