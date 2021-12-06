<?php
namespace src;

include_once 'Conexao.php';
include_once 'Unidade.php';

class UnidadeRepositorio
{

    private $Conexao;

    public function __construct()
    {
        $this->Conexao = new Conexao();
    }
    
    public function cadastrarUnidade($Objeto) 
    {
        $retorno = FALSE;
        $this->Conexao->abrirConexao();
        if ($this->Conexao->getConexao()->query(
            "INSERT INTO UNIDADE(NOME,SIGLA,ENDERECO,DTREGISTRO,SITUACAO) " .
            "VALUES(" . 
            "'" . $Objeto->getNome() . 
            "', '" . $Objeto->getSigla() .
            "', '" . $Objeto->getEndereco() .
            "', NOW(), 0);")) {
                $retorno = TRUE;
            } else {
                echo "Falha no cadastro da Unidade. (REPOSITÓRIO)<br />";
            }
        $this->Conexao->fecharConexao();
        return $retorno;
    }

    public function alterarUnidade($Objeto)
    {
        $retorno = FALSE;
        $this->Conexao->abrirConexao();
        if ($this->Conexao->getConexao()->query(
            "UPDATE UNIDADE SET" .
            " NOME = '" . $Objeto->getNome() .
            "', SIGLA = '" . $Objeto->getSigla() .
            "', ENDERECO = '" . $Objeto->getEndereco() .
            "' WHERE ID = " . $Objeto->getId() . ";")) {
                $retorno = TRUE;
        } else {
            echo "Falha na alteração da Unidade. (REPOSITÓRIO)<br />";
        }
        $this->Conexao->fecharConexao();
        return $retorno;
    }
    
    public function bloquearUnidade($Objeto) {
        $retorno = FALSE;
        $this->Conexao->abrirConexao();
        if ($this->Conexao->getConexao()->query(
            "UPDATE UNIDADE SET" .
            " SITUACAO = 1" .
            " WHERE ID = " . $Objeto->getId() . ";")) {
                $retorno = TRUE;
        } else {
            echo "Falha no bloqueio da Unidade. (REPOSITÓRIO)<br />";
        }
        $this->Conexao->fecharConexao();
        return $retorno;
    }
    
    public function desbloquearUnidade($Objeto) {
        $retorno = FALSE;
        $this->Conexao->abrirConexao();
        if ($this->Conexao->getConexao()->query(
            "UPDATE UNIDADE SET" .
            " SITUACAO = 0" .
            " WHERE ID = " . $Objeto->getId() . ";")) {
            $retorno = TRUE;
        } else {
            echo "Falha no desbloqueio da Unidade. (REPOSITÓRIO)<br />";
        }
        $this->Conexao->fecharConexao();
        return $retorno;
    }
    
    public function excluirUnidade($Objeto) {
        $retorno = FALSE;
        $this->Conexao->abrirConexao();
        if ($this->Conexao->getConexao()->query(
            "DELETE FROM UNIDADE" .
            " WHERE ID = " . $Objeto->getId() . ";")) {
            $retorno = TRUE;
        } else {
            echo "Falha na exclusão da Unidade. (REPOSITÓRIO)<br />";
        }
        $this->Conexao->fecharConexao();
        return $retorno;
    }
    
    public function existeUnidade($Objeto) {
        $retorno = FALSE;
        $this->Conexao->abrirConexao();
        $numeroLinhas = mysqli_num_rows($this->Conexao->getConexao()->query(
            "SELECT * FROM UNIDADE" .
            " WHERE NOME = '" . $Objeto->getNome() . "';"));
        if ($numeroLinhas > 0) {
            $retorno = TRUE;
        }
        $this->Conexao->fecharConexao();
        return $retorno;
    }
    
    public function consultarUnidade($Objeto) {
        $this->Conexao->abrirConexao();
        $codigoSQL = "SELECT * FROM UNIDADE" .
            " WHERE  NOME = '" . $Objeto->getNome() .
            "' OR SIGLA = '" . $Objeto->getSigla() . "';";
        $numeroLinhas = mysqli_num_rows($this->Conexao->getConexao()->query($codigoSQL));
        if ($numeroLinhas > 0) {
            $linha = mysqli_fetch_assoc($this->Conexao->getConexao()->query($codigoSQL));
                $Objeto->setId($linha['ID']);
                $Objeto->setNome($linha['NOME']);
                $Objeto->setSigla($linha['SIGLA']);
                $Objeto->setEndereco($linha['ENDERECO']);
                $Objeto->setDtRegistro($linha['DTREGISTRO']);
                $Objeto->setSituacao($linha['SITUACAO']);
        }
        $this->Conexao->fecharConexao();
        return $Objeto;
    }
    
    public function consultarUnidadePorNome($Objeto)
    {
        $this->Conexao->abrirConexao();
        $codigoSQL = "SELECT * FROM UNIDADE" .
            " WHERE  NOME = '" . $Objeto->getNome() .
            "' AND SITUACAO = 0;";
        $numeroLinhas = mysqli_num_rows($this->Conexao->getConexao()->query($codigoSQL));
        if ($numeroLinhas > 0) {
            $linha = mysqli_fetch_assoc($this->Conexao->getConexao()->query($codigoSQL));
            $Objeto->setId($linha['ID']);
            $Objeto->setNome($linha['NOME']);
            $Objeto->setSigla($linha['SIGLA']);
            $Objeto->setEndereco($linha['ENDERECO']);
            $Objeto->setDtRegistro($linha['DTREGISTRO']);
            $Objeto->setSituacao($linha['SITUACAO']);
        }
        $this->Conexao->fecharConexao();
        return $Objeto;
    }
    
    public function consultarUnidadePorNomeBloqueado($Objeto) {
        $this->Conexao->abrirConexao();
        $codigoSQL = "SELECT * FROM UNIDADE" .
            " WHERE  NOME = '" . $Objeto->getNome() .
            "' AND SITUACAO = 1;";
        $numeroLinhas = mysqli_num_rows($this->Conexao->getConexao()->query($codigoSQL));
        if ($numeroLinhas > 0) {
            $linha = mysqli_fetch_assoc($this->Conexao->getConexao()->query($codigoSQL));
            $Objeto->setId($linha['ID']);
            $Objeto->setNome($linha['NOME']);
            $Objeto->setSigla($linha['SIGLA']);
            $Objeto->setEndereco($linha['ENDERECO']);
            $Objeto->setDtRegistro($linha['DTREGISTRO']);
            $Objeto->setSituacao($linha['SITUACAO']);
        }
        $this->Conexao->fecharConexao();
        return $Objeto;
    }
    
    public function consultarUnidadePorSigla($Objeto) {
        $this->Conexao->abrirConexao();
        $codigoSQL = "SELECT * FROM UNIDADE" .
            " WHERE  SIGLA = '" . $Objeto->getSigla() .
            "' AND SITUACAO = 0;";
        $numeroLinhas = mysqli_num_rows($this->Conexao->getConexao()->query($codigoSQL));
        if ($numeroLinhas > 0) {
            $linha = mysqli_fetch_assoc($this->Conexao->getConexao()->query($codigoSQL));
            $Objeto->setId($linha['ID']);
            $Objeto->setNome($linha['NOME']);
            $Objeto->setSigla($linha['SIGLA']);
            $Objeto->setEndereco($linha['ENDERECO']);
            $Objeto->setDtRegistro($linha['DTREGISTRO']);
            $Objeto->setSituacao($linha['SITUACAO']);
        }
        $this->Conexao->fecharConexao();
        return $Objeto;
    }
    
    public function consultarUnidadePorSiglaBloqueado($Objeto) {
        $this->Conexao->abrirConexao();
        $codigoSQL = "SELECT * FROM UNIDADE" .
            " WHERE  SIGLA = '" . $Objeto->getSigla() .
            "' AND SITUACAO = 1;";
        $numeroLinhas = mysqli_num_rows($this->Conexao->getConexao()->query($codigoSQL));
        if ($numeroLinhas > 0) {
            $linha = mysqli_fetch_assoc($this->Conexao->getConexao()->query($codigoSQL));
            $Objeto->setId($linha['ID']);
            $Objeto->setNome($linha['NOME']);
            $Objeto->setSigla($linha['SIGLA']);
            $Objeto->setEndereco($linha['ENDERECO']);
            $Objeto->setDtRegistro($linha['DTREGISTRO']);
            $Objeto->setSituacao($linha['SITUACAO']);
        } else {
            echo "Unidade inválida.<br />";
        }
        $this->Conexao->fecharConexao();
        return $Objeto;
    }
    
    public function contarTodoUnidade() {
        $quantidade = 0;
        $this->Conexao->abrirConexao();
        $resultado = $this->Conexao->getConexao()->query(
            "SELECT COUNT(ID) AS QUANTIDADE FROM UNIDADE;"
            );
        $numeroLinhas = mysqli_num_rows($resultado);
        if ($numeroLinhas > 0) {
            $linha = mysqli_fetch_assoc($resultado);
            $quantidade = $linha['QUANTIDADE'];
        }
        $this->Conexao->fecharConexao();
        return $quantidade;
    }
    
    public function contarUnidadeDesbloqueado() {
        $quantidade = 0;
        $this->Conexao->abrirConexao();
        $resultado = $this->Conexao->getConexao()->query(
            "SELECT COUNT(ID) AS QUANTIDADE FROM UNIDADE WHERE SITUACAO = 0;");
        $numeroLinhas = mysqli_num_rows($resultado);
        if ($numeroLinhas > 0) {
            $linha = mysqli_fetch_assoc($resultado);
            $quantidade = $linha['QUANTIDADE'];
        }
        $this->Conexao->fecharConexao();
        return $quantidade;
    }

    public function contarUnidadeBloqueado() {
        $quantidade = 0;
        $this->Conexao->abrirConexao();
        $resultado = $this->Conexao->getConexao()->query(
            "SELECT COUNT(ID) AS QUANTIDADE FROM UNIDADE WHERE SITUACAO = 1;");
        $numeroLinhas = mysqli_num_rows($resultado);
        if ($numeroLinhas > 0) {
            $linha = mysqli_fetch_assoc($resultado);
            $quantidade = $linha['QUANTIDADE'];
        }
        $this->Conexao->fecharConexao();
        return $quantidade;
    }
    
    public function listarUnidade() {
        $lista = null;
        $this->Conexao->abrirConexao();
        $resultado = $this->Conexao->getConexao()->query(
            "SELECT * FROM UNIDADE ORDER BY NOME;");
        $numeroLinhas = mysqli_num_rows($resultado);
        if ($numeroLinhas > 0) {
            $c = 0;
            while ($linha = mysqli_fetch_assoc($resultado)) {
                $Unidade = new Unidade();
                $Unidade->setId($linha['ID']);
                $Unidade->setNome($linha['NOME']);
                $Unidade->setSigla($linha['SIGLA']);
                $Unidade->setEndereco($linha['ENDERECO']);
                $Unidade->setDtRegistro($linha['DTREGISTRO']);
                $Unidade->setSituacao($linha['SITUACAO']);
                $lista[$c] = $Unidade;
                $c++;
            }
        }
        $this->Conexao->fecharConexao();
        return $lista;
    }
    
    public function listarUnidadeDesbloqueado() {
        $lista = null;
        $this->Conexao->abrirConexao();
        $resultado = $this->Conexao->getConexao()->query(
            "SELECT * FROM UNIDADE WHERE SITUACAO = 0 ORDER BY NOME;");
        $numeroLinhas = mysqli_num_rows($resultado);
        if ($numeroLinhas > 0) {
            $c = 0;
            while ($linha = mysqli_fetch_assoc($resultado)) {
                $Unidade = new Unidade();
                $Unidade->setId($linha['ID']);
                $Unidade->setNome($linha['NOME']);
                $Unidade->setSigla($linha['SIGLA']);
                $Unidade->setEndereco($linha['ENDERECO']);
                $Unidade->setDtRegistro($linha['DTREGISTRO']);
                $Unidade->setSituacao($linha['SITUACAO']);
                $lista[$c] = $Unidade;
                $c++;
            }
        }
        $this->Conexao->fecharConexao();
        return $lista;
    }
    
    public function listarUnidadeBloqueado() {
        $lista = null;
        $this->Conexao->abrirConexao();
        $resultado = $this->Conexao->getConexao()->query(
            "SELECT * FROM UNIDADE WHERE SITUACAO = 1 ORDER BY NOME;");
        $numeroLinhas = mysqli_num_rows($resultado);
        if ($numeroLinhas > 0) {
            $c = 0;
            while ($linha = mysqli_fetch_assoc($resultado)) {
                $Unidade = new Unidade();
                $Unidade->setId($linha['ID']);
                $Unidade->setNome($linha['NOME']);
                $Unidade->setSigla($linha['SIGLA']);
                $Unidade->setEndereco($linha['ENDERECO']);
                $Unidade->setDtRegistro($linha['DTREGISTRO']);
                $Unidade->setSituacao($linha['SITUACAO']);
                $lista[$c] = $Unidade;
                $c++;
            }
        }
        $this->Conexao->fecharConexao();
        return $lista;
    }
    
    
}
