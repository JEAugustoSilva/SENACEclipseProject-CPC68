<?php
namespace src;

include_once 'Conexao.php';
include_once 'Cargo.php';

class CargoRepositorio
{

    private $Conexao;

    public function __construct()
    {
        $this->Conexao = new Conexao();
    }
    
    public function cadastrarCargo($Objeto)
    {
        $retorno = FALSE;
        $this->Conexao->abrirConexao();
        if ($this->Conexao->getConexao()->query(
            "INSERT INTO CARGO(NOME,DESCRICAO,DTREGISTRO,SITUACAO) " .
            "VALUES(" .
            "'" . $Objeto->getNome() .
            "', '" . $Objeto->getDescricao() .
            "', NOW(), 0);")) {
            $retorno = TRUE;
        } else {
            echo "Falha no cadastro do Cargo. (REPOSITÓRIO)<br />";
        }
        $this->Conexao->fecharConexao();
        return $retorno;
    }
    
    public function alterarCargo($Objeto)
    {
        $retorno = FALSE;
        $this->Conexao->abrirConexao();
        if ($this->Conexao->getConexao()->query(
            "UPDATE CARGO SET" .
            " NOME = '" . $Objeto->getNome() .
            "', DESCRICAO = '" . $Objeto->getDescricao() .
            "' WHERE ID = " . $Objeto->getId() . ";")) {
            $retorno = TRUE;
        } else {
            echo "Falha na alteração do Cargo. (REPOSITÓRIO)<br />";
        }
        $this->Conexao->fecharConexao();
        return $retorno;
    }
    
    public function bloquearCargo($Objeto) {
        $retorno = FALSE;
        $this->Conexao->abrirConexao();
        if ($this->Conexao->getConexao()->query(
            "UPDATE CARGO SET" .
            " SITUACAO = 1" .
            " WHERE ID = " . $Objeto->getId() . ";")) {
            $retorno = TRUE;
        } else {
            echo "Falha no bloqueio do Cargo. (REPOSITÓRIO)<br />";
        }
        $this->Conexao->fecharConexao();
        return $retorno;
    }
    
    public function desbloquearCargo($Objeto) {
        $retorno = FALSE;
        $this->Conexao->abrirConexao();
        if ($this->Conexao->getConexao()->query(
            "UPDATE CARGO SET" .
            " SITUACAO = 0" .
            " WHERE ID = " . $Objeto->getId() . ";")) {
            $retorno = TRUE;
        } else {
            echo "Falha no desbloqueio do Cargo. (REPOSITÓRIO)<br />";
        }
        $this->Conexao->fecharConexao();
        return $retorno;
    }
    
    public function excluirCargo($Objeto) {
        $retorno = FALSE;
        $this->Conexao->abrirConexao();
        if ($this->Conexao->getConexao()->query(
            "DELETE FROM CARGO" .
            " WHERE ID = " . $Objeto->getId() . ";")) {
            $retorno = TRUE;
        } else {
            echo "Falha na exclusão do Cargo. (REPOSITÓRIO)<br />";
        }
        $this->Conexao->fecharConexao();
        return $retorno;
    }
    
    public function existeCargo($Objeto) {
        $retorno = FALSE;
        $this->Conexao->abrirConexao();
        $numeroLinhas = mysqli_num_rows($this->Conexao->getConexao()->query(
            "SELECT * FROM CARGO" .
            " WHERE NOME = '" . $Objeto->getNome() . "';"));
        if ($numeroLinhas > 0) {
            $retorno = TRUE;
        }
        $this->Conexao->fecharConexao();
        return $retorno;
    }
    
    public function consultarCargo($Objeto) {
        $this->Conexao->abrirConexao();
        $codigoSQL = "SELECT * FROM CARGO" .
            " WHERE  NOME = '" . $Objeto->getNome() . "';";
        $numeroLinhas = mysqli_num_rows($this->Conexao->getConexao()->query($codigoSQL));
        if ($numeroLinhas > 0) {
            $linha = mysqli_fetch_assoc($this->Conexao->getConexao()->query($codigoSQL));
            $Objeto->setId($linha['ID']);
            $Objeto->setNome($linha['NOME']);
            $Objeto->setDescricao($linha['DESCRICAO']);
            $Objeto->setDtRegistro($linha['DTREGISTRO']);
            $Objeto->setSituacao($linha['SITUACAO']);
        }
        $this->Conexao->fecharConexao();
        return $Objeto;
    }
    
    public function consultarCargoPorNome($Objeto)
    {
        $this->Conexao->abrirConexao();
        $codigoSQL = "SELECT * FROM CARGO" .
            " WHERE  NOME = '" . $Objeto->getNome() .
            "' AND SITUACAO = 0;";
        $numeroLinhas = mysqli_num_rows($this->Conexao->getConexao()->query($codigoSQL));
        if ($numeroLinhas > 0) {
            $linha = mysqli_fetch_assoc($this->Conexao->getConexao()->query($codigoSQL));
            $Objeto->setId($linha['ID']);
            $Objeto->setNome($linha['NOME']);
            $Objeto->setDescricao($linha['DESCRICAO']);
            $Objeto->setDtRegistro($linha['DTREGISTRO']);
            $Objeto->setSituacao($linha['SITUACAO']);
        }
        $this->Conexao->fecharConexao();
        return $Objeto;
    }
    
    public function consultarCargoPorNomeBloqueado($Objeto)
    {
        $this->Conexao->abrirConexao();
        $codigoSQL = "SELECT * FROM CARGO" .
            " WHERE  NOME = '" . $Objeto->getNome() .
            "' AND SITUACAO = 1;";
        $numeroLinhas = mysqli_num_rows($this->Conexao->getConexao()->query($codigoSQL));
        if ($numeroLinhas > 0) {
            $linha = mysqli_fetch_assoc($this->Conexao->getConexao()->query($codigoSQL));
            $Objeto->setId($linha['ID']);
            $Objeto->setNome($linha['NOME']);
            $Objeto->setDescricao($linha['DESCRICAO']);
            $Objeto->setDtRegistro($linha['DTREGISTRO']);
            $Objeto->setSituacao($linha['SITUACAO']);
        }
        $this->Conexao->fecharConexao();
        return $Objeto;
    }
    
    public function contarTodoCargo() {
        $quantidade = 0;
        $this->Conexao->abrirConexao();
        $resultado = $this->Conexao->getConexao()->query(
            "SELECT COUNT(ID) AS QUANTIDADE FROM CARGO");
        $numeroLinhas = mysqli_num_rows($resultado);
        if ($numeroLinhas > 0) {
            $linha = mysqli_fetch_assoc($resultado);
            $quantidade = $linha['QUANTIDADE'];
        }
        $this->Conexao->fecharConexao();
        return $quantidade;
    }
    
    public function contarCargoDesbloqueado() {
        $quantidade = 0;
        $this->Conexao->abrirConexao();
        $resultado = $this->Conexao->getConexao()->query(
            "SELECT COUNT(ID) AS QUANTIDADE FROM CARGO WHERE SITUACAO = 0;");
        $numeroLinhas = mysqli_num_rows($resultado);
        if ($numeroLinhas > 0) {
            $linha = mysqli_fetch_assoc($resultado);
            $quantidade = $linha['QUANTIDADE'];
        }
        $this->Conexao->fecharConexao();
        return $quantidade;
    }
    
    public function contarCargoBloqueado() {
        $quantidade = 0;
        $this->Conexao->abrirConexao();
        $resultado = $this->Conexao->getConexao()->query(
            "SELECT COUNT(ID) AS QUANTIDADE FROM CARGO WHERE SITUACAO = 1;");
        $numeroLinhas = mysqli_num_rows($resultado);
        if ($numeroLinhas > 0) {
            $linha = mysqli_fetch_assoc($resultado);
            $quantidade = $linha['QUANTIDADE'];
        }
        $this->Conexao->fecharConexao();
        return $quantidade;
    }
    
    public function listarCargo() {
        $lista = null;
        $this->Conexao->abrirConexao();
        $resultado = $this->Conexao->getConexao()->query(
            "SELECT * FROM CARGO ORDER BY NOME;");
        $numeroLinhas = mysqli_num_rows($resultado);
        if ($numeroLinhas > 0) {
            $c = 0;
            while ($linha = mysqli_fetch_assoc($resultado)) {
                $Cargo = new Cargo();
                $Cargo->setId($linha['ID']);
                $Cargo->setNome($linha['NOME']);
                $Cargo->setDescricao($linha['DESCRICAO']);
                $Cargo->setDtRegistro($linha['DTREGISTRO']);
                $Cargo->setSituacao($linha['SITUACAO']);
                $lista[$c] = $Cargo;
                $c++;
            }
        }
        $this->Conexao->fecharConexao();
        return $lista;
    }
    
    public function listarCargoDesbloqueado() {
        $lista = null;
        $this->Conexao->abrirConexao();
        $resultado = $this->Conexao->getConexao()->query(
            "SELECT * FROM CARGO WHERE SITUACAO = 0 ORDER BY NOME;");
        $numeroLinhas = mysqli_num_rows($resultado);
        if ($numeroLinhas > 0) {
            $c = 0;
            while ($linha = mysqli_fetch_assoc($resultado)) {
                $Cargo = new Cargo();
                $Cargo->setId($linha['ID']);
                $Cargo->setNome($linha['NOME']);
                $Cargo->setDescricao($linha['DESCRICAO']);
                $Cargo->setDtRegistro($linha['DTREGISTRO']);
                $Cargo->setSituacao($linha['SITUACAO']);
                $lista[$c] = $Cargo;
                $c++;
            }
        }
        $this->Conexao->fecharConexao();
        return $lista;
    }
    
    public function listarCargoBloqueado() {
        $lista = null;
        $this->Conexao->abrirConexao();
        $resultado = $this->Conexao->getConexao()->query(
            "SELECT * FROM CARGO WHERE SITUACAO = 1 ORDER BY NOME;");
        $numeroLinhas = mysqli_num_rows($resultado);
        if ($numeroLinhas > 0) {
            $c = 0;
            while ($linha = mysqli_fetch_assoc($resultado)) {
                $Cargo = new Cargo();
                $Cargo->setId($linha['ID']);
                $Cargo->setNome($linha['NOME']);
                $Cargo->setDescricao($linha['DESCRICAO']);
                $Cargo->setDtRegistro($linha['DTREGISTRO']);
                $Cargo->setSituacao($linha['SITUACAO']);
                $lista[$c] = $Cargo;
                $c++;
            }
        }
        $this->Conexao->fecharConexao();
        return $lista;
    }
}