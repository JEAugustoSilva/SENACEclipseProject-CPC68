<?php
session_start();

include_once 'src/Grupo.php';
include_once 'src/GrupoRepositorio.php';

use src\Grupo;
use src\GrupoRepositorio;
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
    $Grupo = new Grupo();
    $Grupo->setId($_GET['id']);
    $Grupo->setNome($_GET['nome']);
    
    $GrupoRepositorio = new GrupoRepositorio();
    $retorno = $GrupoRepositorio->excluirGrupo($Grupo);
    if ($retorno == TRUE) {
        header('Location: consultarGrupo.php');
    } else {
        echo "Falha na exclusão!";
        echo "<a href='consultarGrupo2.php?nome=" . $Grupo->getNome() . "'>Voltar</a>";
    }
?>
</body>
</html>
