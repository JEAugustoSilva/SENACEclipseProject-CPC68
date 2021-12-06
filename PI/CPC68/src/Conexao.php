<?php
namespace src;

// Importar o drive do MySQL
use mysqli;

class Conexao
{

    private $conexao;

    private $servidor;

    private $banco;

    private $usuarioBanco;

    private $senhaBanco;

    private $charset;

    private $url;

    public function __construct()
    {
        $this->servidor = "localhost";
        $this->usuarioBanco = "root";
        $this->senhaBanco = "123456";
        $this->banco = "DBCPC68";
        $this->charset = "UTF8";
    }

    public function abrirConexao()
    {
        $this->conexao = new mysqli($this->servidor, $this->usuarioBanco, $this->senhaBanco, $this->banco);

        if (! $this->conexao) {
            echo "Falha na conexão: " . mysqli_error($this->conexao);
        } else {
            return $this->conexao;
        }
    }

    public function abrirConexaoSemBanco()
    {
        $this->conexao = new mysqli($this->servidor, $this->usuarioBanco, $this->senhaBanco);

        if (! $this->conexao) {
            echo "Falha na conexão: " . mysqli_error($this->conexao);
        } else {
            return $this->conexao;
        }
    }

    public function fecharConexao()
    {
        $this->conexao->close();
    }

    public function getConexao()
    {
        return $this->conexao;
    }
}
?>