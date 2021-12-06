<?php
namespace src;

include_once 'Conexao.php';
include_once 'Grupo.php';

class GrupoRepositorio
{
    private $Conexao;
    
    public function __construct()
    {
        $this->Conexao = new Conexao();
    }
    
    public function cadastrarGrupo($Objeto)
    {
        $retorno = FALSE;
        $this->Conexao->abrirConexao();
        if ($this->Conexao->getConexao()->query(
            "INSERT INTO GRUPO(NOME,DESCRICAO,DTREGISTRO,SITUACAO) " .
            "VALUES(" .
            "'" . $Objeto->getNome() .
            "', '" . $Objeto->getDescricao() .
            "', NOW(), 0);")) {
            $retorno = TRUE;
        } else {
            echo "Falha no cadastro do grupo. (REPOSITÓRIO)<br />";
        }
        $this->Conexao->fecharConexao();
        return $retorno;
    }
    
    public function alterarGrupo($Objeto)
    {
        $retorno = FALSE;
        $this->Conexao->abrirConexao();
        if ($this->Conexao->getConexao()->query(
            "UPDATE GRUPO SET" .
            " NOME = '" . $Objeto->getNome() .
            "', DESCRICAO = '" . $Objeto->getDescricao() .
            "' WHERE ID = " . $Objeto->getId() . ";")) {
            $retorno = TRUE;
        } else {
            echo "Falha na alteração do Grupo. (REPOSITÓRIO)<br />";
        }
        $this->Conexao->fecharConexao();
        return $retorno;
    }
    
    public function bloquearGrupo($Objeto) {
        $retorno = FALSE;
        $this->Conexao->abrirConexao();
        if ($this->Conexao->getConexao()->query(
            "UPDATE GRUPO SET" .
            " SITUACAO = 1" .
            " WHERE ID = " . $Objeto->getId() . ";")) {
            $retorno = TRUE;
        } else {
            echo "Falha no bloqueio do grupo. (REPOSITÓRIO)<br />";
        }
        $this->Conexao->fecharConexao();
        return $retorno;
    }
    
    public function desbloquearGrupo($Objeto) {
        $retorno = FALSE;
        $this->Conexao->abrirConexao();
        if ($this->Conexao->getConexao()->query(
            "UPDATE GRUPO SET" .
            " SITUACAO = 0" .
            " WHERE ID = " . $Objeto->getId() . ";")) {
            $retorno = TRUE;
        } else {
            echo "Falha no desbloqueio do grupo. (REPOSITÓRIO)<br />";
        }
        $this->Conexao->fecharConexao();
        return $retorno;
    }
    
    public function excluirGrupo($Objeto) {
        $retorno = FALSE;
        $this->Conexao->abrirConexao();
        if ($this->Conexao->getConexao()->query(
            "DELETE FROM GRUPO" .
            " WHERE ID = " . $Objeto->getId() . ";")) {
            $retorno = TRUE;
        } else {
            echo "Falha na exclusão do Grupo. (REPOSITÓRIO)<br />";
        }
        $this->Conexao->fecharConexao();
        return $retorno;
    }
    
    public function existeGrupo($Objeto) {
        $retorno = FALSE;
        $this->Conexao->abrirConexao();
        $numeroLinhas = mysqli_num_rows($this->Conexao->getConexao()->query(
            "SELECT * FROM GRUPO" .
            " WHERE NOME = '" . $Objeto->getNome() . "';"));
        if ($numeroLinhas > 0) {
            $retorno = TRUE;
        }
        $this->Conexao->fecharConexao();
        return $retorno;
    }
    
    public function consultarGrupo($Objeto) {
        $this->Conexao->abrirConexao();
        $codigoSQL = "SELECT * FROM GRUPO" .
            " WHERE  NOME = '" . $Objeto->getNome() . "';";
        $numeroLinhas = mysqli_num_rows($this->Conexao->getConexao()->query($codigoSQL));
        if ($numeroLinhas > 0) {
            $linha = mysqli_fetch_assoc($this->Conexao->getConexao()->query($codigoSQL));
            $Objeto->setId($linha['ID']);
            $Objeto->setNome($linha['NOME']);
            $Objeto->setDescricao($linha['DESCRICAO']);
            $Objeto->setDtRegistro($linha['DTREGISTRO']);
            $Objeto->setSituacao($linha['SITUACAO']);
        } else {
            echo "Grupo inválido.<br />";
        }
        $this->Conexao->fecharConexao();
        return $Objeto;
    }
    
    public function consultarGrupoPorNome($Objeto)
    {
        $this->Conexao->abrirConexao();
        $codigoSQL = "SELECT * FROM GRUPO" .
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
        } else {
            echo "Grupo inválido.<br />";
        }
        $this->Conexao->fecharConexao();
        return $Objeto;
    }
    
    public function consultarGrupoPorNomeBloqueado($Objeto)
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
        } else {
            echo "Grupo inválido.<br />";
        }
        $this->Conexao->fecharConexao();
        return $Objeto;
    }
    
    public function contarTodoGrupo() {
        $quantidade = 0;
        $this->Conexao->abrirConexao();
        $resultado = $this->Conexao->getConexao()->query(
            "SELECT COUNT(ID) AS QUANTIDADE FROM GRUPO");
        $numeroLinhas = mysqli_num_rows($resultado);
        if ($numeroLinhas > 0) {
            $linha = mysqli_fetch_assoc($resultado);
            $quantidade = $linha['QUANTIDADE'];
        }
        $this->Conexao->fecharConexao();
        return $quantidade;
    }
    
    public function contarGrupoDesbloqueado() {
        $quantidade = 0;
        $this->Conexao->abrirConexao();
        $resultado = $this->Conexao->getConexao()->query(
            "SELECT COUNT(ID) AS QUANTIDADE FROM GRUPO WHERE SITUACAO = 0;");
        $numeroLinhas = mysqli_num_rows($resultado);
        if ($numeroLinhas > 0) {
            $linha = mysqli_fetch_assoc($resultado);
            $quantidade = $linha['QUANTIDADE'];
        }
        $this->Conexao->fecharConexao();
        return $quantidade;
    }
    
    public function contarGrupoBloqueado() {
        $quantidade = 0;
        $this->Conexao->abrirConexao();
        $resultado = $this->Conexao->getConexao()->query(
            "SELECT COUNT(ID) AS QUANTIDADE FROM GRUPO WHERE SITUACAO = 1;");
        $numeroLinhas = mysqli_num_rows($resultado);
        if ($numeroLinhas > 0) {
            $linha = mysqli_fetch_assoc($resultado);
            $quantidade = $linha['QUANTIDADE'];
        }
        $this->Conexao->fecharConexao();
        return $quantidade;
    }
    
    public function listarTodoGrupo() {
        $lista = null;
        $this->Conexao->abrirConexao();
        $resultado = $this->Conexao->getConexao()->query(
            "SELECT * FROM GRUPO ORDER BY NOME;");
        $numeroLinhas = mysqli_num_rows($resultado);
        if ($numeroLinhas > 0) {
            $c = 0;
            while ($linha = mysqli_fetch_assoc($resultado)) {
                $Grupo = new Grupo();
                $Grupo->setId($linha['ID']);
                $Grupo->setNome($linha['NOME']);
                $Grupo->setDescricao($linha['DESCRICAO']);
                $Grupo->setDtRegistro($linha['DTREGISTRO']);
                $Grupo->setSituacao($linha['SITUACAO']);
                $lista[$c] = $Grupo;
                $c++;
            }
        }
        $this->Conexao->fecharConexao();
        return $lista;
    }
    
    public function listarGrupoDesbloqueado() {
        $lista = null;
        $this->Conexao->abrirConexao();
        $resultado = $this->Conexao->getConexao()->query(
            "SELECT * FROM GRUPO WHERE SITUACAO = 0 ORDER BY NOME;");
        $numeroLinhas = mysqli_num_rows($resultado);
        if ($numeroLinhas > 0) {
            $c = 0;
            while ($linha = mysqli_fetch_assoc($resultado)) {
                $Grupo = new Grupo();
                $Grupo->setId($linha['ID']);
                $Grupo->setNome($linha['NOME']);
                $Grupo->setDescricao($linha['DESCRICAO']);
                $Grupo->setDtRegistro($linha['DTREGISTRO']);
                $Grupo->setSituacao($linha['SITUACAO']);
                $lista[$c] = $Grupo;
                $c++;
            }
        }
        $this->Conexao->fecharConexao();
        return $lista;
    }
    
    public function listarGrupoBloqueado() {
        $lista = null;
        $this->Conexao->abrirConexao();
        $resultado = $this->Conexao->getConexao()->query(
            "SELECT * FROM GRUPO WHERE SITUACAO = 1 ORDER BY NOME;");
        $numeroLinhas = mysqli_num_rows($resultado);
        if ($numeroLinhas > 0) {
            $c = 0;
            while ($linha = mysqli_fetch_assoc($resultado)) {
                $Grupo = new Grupo();
                $Grupo->setId($linha['ID']);
                $Grupo->setNome($linha['NOME']);
                $Grupo->setDescricao($linha['DESCRICAO']);
                $Grupo->setDtRegistro($linha['DTREGISTRO']);
                $Grupo->setSituacao($linha['SITUACAO']);
                $lista[$c] = $Grupo;
                $c++;
            }
        }
        $this->Conexao->fecharConexao();
        return $lista;
    }
}