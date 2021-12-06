<?php
namespace src;

include_once 'Conexao.php';
include_once 'Grupo.php';
include_once 'Subgrupo.php';

class SubgrupoRepositorio
{

    private $Conexao;

    public function __construct()
    {
        $this->Conexao = new Conexao();
    }
    
    public function cadastrarSubgrupo($Objeto) {
        $retorno = FALSE;
        $this->Conexao->abrirConexao();
        if ($this->Conexao->getConexao()->query(
            "INSERT INTO SUBGRUPO(IDGRUPO,NOME,DESCRICAO,DTREGISTRO,SITUACAO) " .
            "VALUES(" .
            "    " . $Objeto->getGrupo()->getId() .
            ",  '" . $Objeto->getNome() .
            "', '" . $Objeto->getDescricao() .
            "', NOW(), 0);")) {
            $retorno = TRUE;
        } else {
            echo "Falha no cadastro do subgrupo. (REPOSITÓRIO)<br />";
        }
        $this->Conexao->fecharConexao();
        return $retorno;
    }
    
    public function alterarSubgrupo($Objeto)
    {
        $retorno = FALSE;
        $this->Conexao->abrirConexao();
        if ($this->Conexao->getConexao()->query(
            "UPDATE SUBGRUPO SET" .
            " IDGRUPO = " . $Objeto->getGrupo()->getId() .
            ", NOME = '" . $Objeto->getNome() .
            "', DESCRICAO = '" . $Objeto->getDescricao() .
            "' WHERE ID = " . $Objeto->getId() . ";")) {
            $retorno = TRUE;
        } else {
            echo "Falha na alteração do subgrupo. (REPOSITÓRIO)<br />";
        }
        $this->Conexao->fecharConexao();
        return $retorno;
    }
    
    public function bloquearSubgrupo($Objeto)
    {
        $retorno = FALSE;
        $this->Conexao->abrirConexao();
        if ($this->Conexao->getConexao()->query(
            "UPDATE SUBGRUPO SET" .
            " SITUACAO = 1" .
            " WHERE ID = " . $Objeto->getId() . ";")) {
            $retorno = TRUE;
        } else {
            echo "Falha no bloqueio do subgrupo. (REPOSITÓRIO)<br />";
        }
        $this->Conexao->fecharConexao();
        return $retorno;
    }
    
    public function desbloquearSubgrupo($Objeto)
    {
        $retorno = FALSE;
        $this->Conexao->abrirConexao();
        if ($this->Conexao->getConexao()->query(
            "UPDATE SUBGRUPO SET" .
            " SITUACAO = 0" .
            " WHERE ID = " . $Objeto->getId() . ";")) {
            $retorno = TRUE;
        } else {
            echo "Falha no desbloqueio do subgrupo. (REPOSITÓRIO)<br />";
        }
        $this->Conexao->fecharConexao();
        return $retorno;
    }
    
    public function excluirSubgrupo($Objeto)
    {
        $retorno = FALSE;
        $this->Conexao->abrirConexao();
        if ($this->Conexao->getConexao()->query(
            "DELETE FROM SUBGRUPO" .
            " WHERE ID = " . $Objeto->getId() . ";")) {
            $retorno = TRUE;
        } else {
            echo "Falha na exclusão do subgrupo. (REPOSITÓRIO)<br />";
        }
        $this->Conexao->fecharConexao();
        return $retorno;
    }
    
    public function existeSubgrupo($Objeto)
    {
        $retorno = FALSE;
        $this->Conexao->abrirConexao();
        $numeroLinhas = mysqli_num_rows($this->Conexao->getConexao()->query(
            "SELECT * FROM SUBGRUPO" .
            " WHERE IDGRUPO = " . $Objeto->getGrupo()->getId() .
            " AND NOME = '" . $Objeto->getNome() . "';"));
        if ($numeroLinhas > 0) {
            $retorno = TRUE;
        }
        $this->Conexao->fecharConexao();
        return $retorno;
    }
    
    public function consultarSubgrupo($Objeto) {
        $this->Conexao->abrirConexao();
        $codigoSQL = "SELECT * FROM SUBGRUPO" .
            " WHERE  NOME = '" . $Objeto->getNome() . "';";
        $numeroLinhas = mysqli_num_rows($this->Conexao->getConexao()->query($codigoSQL));
        if ($numeroLinhas > 0) {
            $linha = mysqli_fetch_assoc($this->Conexao->getConexao()->query($codigoSQL));
            $Objeto->setId($linha['ID']);
            $Grupo = new Grupo();
            $Grupo->setId($linha['IDGRUPO']);
            $Objeto->setGrupo($Grupo);
            $Objeto->setNome($linha['NOME']);
            $Objeto->setDescricao($linha['DESCRICAO']);
            $Objeto->setDtRegistro($linha['DTREGISTRO']);
            $Objeto->setSituacao($linha['SITUACAO']);
        }
        $this->Conexao->fecharConexao();
        return $Objeto;
    }
    
    public function consultarSubgrupoPorNome($Objeto) {
        $this->Conexao->abrirConexao();
        $codigoSQL = "SELECT * FROM SUBGRUPO" .
            " WHERE  NOME = '" . $Objeto->getNome() .
            "' AND SITUACAO = 0;";
        $numeroLinhas = mysqli_num_rows($this->Conexao->getConexao()->query($codigoSQL));
        if ($numeroLinhas > 0) {
            $linha = mysqli_fetch_assoc($this->Conexao->getConexao()->query($codigoSQL));
            $Objeto->setId($linha['ID']);
            $Grupo = new Grupo();
            $Grupo->setId($linha['IDGRUPO']);
            $Objeto->setGrupo($Grupo);
            $Objeto->setNome($linha['NOME']);
            $Objeto->setDescricao($linha['DESCRICAO']);
            $Objeto->setDtRegistro($linha['DTREGISTRO']);
            $Objeto->setSituacao($linha['SITUACAO']);
        }
        $this->Conexao->fecharConexao();
        return $Objeto;
    }
    
    public function consultarSubgrupoPorNomeBloqueado($Objeto) {
        $this->Conexao->abrirConexao();
        $codigoSQL = "SELECT * FROM SUBGRUPO" .
            " WHERE  NOME = '" . $Objeto->getNome() .
            "' AND SITUACAO = 1;";
        $numeroLinhas = mysqli_num_rows($this->Conexao->getConexao()->query($codigoSQL));
        if ($numeroLinhas > 0) {
            $linha = mysqli_fetch_assoc($this->Conexao->getConexao()->query($codigoSQL));
            $Objeto->setId($linha['ID']);
            $Grupo = new Grupo();
            $Grupo->setId($linha['IDGRUPO']);
            $Objeto->setGrupo($Grupo);
            $Objeto->setNome($linha['NOME']);
            $Objeto->setDescricao($linha['DESCRICAO']);
            $Objeto->setDtRegistro($linha['DTREGISTRO']);
            $Objeto->setSituacao($linha['SITUACAO']);
        }
        $this->Conexao->fecharConexao();
        return $Objeto;
    }
    
    public function contarSubgrupo() {
        $quantidade = 0;
        $this->Conexao->abrirConexao();
        $resultado = $this->Conexao->getConexao()->query(
            "SELECT COUNT(ID) AS QUANTIDADE FROM SUBGRUPO;"
            );
        $numeroLinhas = mysqli_num_rows($resultado);
        if ($numeroLinhas > 0) {
            $linha = mysqli_fetch_assoc($resultado);
            $quantidade = $linha['QUANTIDADE'];
        }
        $this->Conexao->fecharConexao();
        return $quantidade;
    }
    
    public function contarSubgrupoDesbloqueado() {
        $quantidade = 0;
        $this->Conexao->abrirConexao();
        $resultado = $this->Conexao->getConexao()->query(
            "SELECT COUNT(ID) AS QUANTIDADE FROM SUBGRUPO WHERE SITUACAO = 0;"
            );
        $numeroLinhas = mysqli_num_rows($resultado);
        if ($numeroLinhas > 0) {
            $linha = mysqli_fetch_assoc($resultado);
            $quantidade = $linha['QUANTIDADE'];
        }
        $this->Conexao->fecharConexao();
        return $quantidade;
    }
    
    public function contarSubgrupoBloqueado() {
        $quantidade = 0;
        $this->Conexao->abrirConexao();
        $resultado = $this->Conexao->getConexao()->query(
            "SELECT COUNT(ID) AS QUANTIDADE FROM SUBGRUPO WHERE SITUACAO = 1;"
            );
        $numeroLinhas = mysqli_num_rows($resultado);
        if ($numeroLinhas > 0) {
            $linha = mysqli_fetch_assoc($resultado);
            $quantidade = $linha['QUANTIDADE'];
        }
        $this->Conexao->fecharConexao();
        return $quantidade;
    }
    
    public function contarSubgrupoPorGrupo($idGrupo) {
        $quantidade = 0;
        $this->Conexao->abrirConexao();
        $resultado = $this->Conexao->getConexao()->query(
            "SELECT COUNT(ID) AS QUANTIDADE FROM SUBGRUPO " .
            "WHERE IDGRUPO = " . $idGrupo . ";");
        $numeroLinhas = mysqli_num_rows($resultado);
        if ($numeroLinhas > 0) {
            $linha = mysqli_fetch_assoc($resultado);
            $quantidade = $linha['QUANTIDADE'];
        }
        $this->Conexao->fecharConexao();
        return $quantidade;
    }
    
    public function listarSubgrupo() {
        $lista = null;
        $this->Conexao->abrirConexao();
        $resultado = $this->Conexao->getConexao()->query(
            "SELECT * FROM SUBGRUPO ORDER BY NOME;");
        $numeroLinhas = mysqli_num_rows($resultado);
        if ($numeroLinhas > 0) {
            $c = 0;
            while ($linha = mysqli_fetch_assoc($resultado)) {
                $Subgrupo = new Subgrupo();
                $Subgrupo->setId($linha['ID']);
                $Grupo = new Grupo();
                $Grupo->setId($linha['IDGRUPO']);
                $Subgrupo->setGrupo($Grupo);
                $Subgrupo->setNome($linha['NOME']);
                $Subgrupo->setDescricao($linha['DESCRICAO']);
                $Subgrupo->setDtRegistro($linha['DTREGISTRO']);
                $Subgrupo->setSituacao($linha['SITUACAO']);
                $lista[$c] = $Subgrupo;
                $c++;
            }
        }
        $this->Conexao->fecharConexao();
        return $lista;
    }
    
    public function listarSubgrupoDesbloqueado() {
        $lista = null;
        $this->Conexao->abrirConexao();
        $resultado = $this->Conexao->getConexao()->query(
            "SELECT * FROM SUBGRUPO WHERE SITUACAO = 0 ORDER BY NOME;");
        $numeroLinhas = mysqli_num_rows($resultado);
        if ($numeroLinhas > 0) {
            $c = 0;
            while ($linha = mysqli_fetch_assoc($resultado)) {
                $Subgrupo = new Subgrupo();
                $Subgrupo->setId($linha['ID']);
                $Grupo = new Grupo();
                $Grupo->setId($linha['IDGRUPO']);
                $Subgrupo->setGrupo($Grupo);
                $Subgrupo->setNome($linha['NOME']);
                $Subgrupo->setDescricao($linha['DESCRICAO']);
                $Subgrupo->setDtRegistro($linha['DTREGISTRO']);
                $Subgrupo->setSituacao($linha['SITUACAO']);
                $lista[$c] = $Subgrupo;
                $c++;
            }
        }
        $this->Conexao->fecharConexao();
        return $lista;
    }
    
    public function listarSubgrupoBloqueado() {
        $lista = null;
        $this->Conexao->abrirConexao();
        $resultado = $this->Conexao->getConexao()->query(
            "SELECT * FROM SUBGRUPO WHERE SITUACAO = 1 ORDER BY NOME;");
        $numeroLinhas = mysqli_num_rows($resultado);
        if ($numeroLinhas > 0) {
            $c = 0;
            while ($linha = mysqli_fetch_assoc($resultado)) {
                $Subgrupo = new Subgrupo();
                $Subgrupo->setId($linha['ID']);
                $Grupo = new Grupo();
                $Grupo->setId($linha['IDGRUPO']);
                $Subgrupo->setGrupo($Grupo);
                $Subgrupo->setNome($linha['NOME']);
                $Subgrupo->setDescricao($linha['DESCRICAO']);
                $Subgrupo->setDtRegistro($linha['DTREGISTRO']);
                $Subgrupo->setSituacao($linha['SITUACAO']);
                $lista[$c] = $Subgrupo;
                $c++;
            }
        }
        $this->Conexao->fecharConexao();
        return $lista;
    }
    
    public function listarSubgrupoPorGrupo($idGrupo) {
        $lista = null;
        $this->Conexao->abrirConexao();
        $resultado = $this->Conexao->getConexao()->query(
            "SELECT * FROM SUBGRUPO WHERE IDGRUPO = " . $idGrupo . " ORDER BY NOME;");
        $numeroLinhas = mysqli_num_rows($resultado);
        if ($numeroLinhas > 0) {
            $c = 0;
            while ($linha = mysqli_fetch_assoc($resultado)) {
                $Subgrupo = new Subgrupo();
                $Subgrupo->setId($linha['ID']);
                $Grupo = new Grupo();
                $Grupo->setId($linha['IDGRUPO']);
                $Subgrupo->setGrupo($Grupo);
                $Subgrupo->setNome($linha['NOME']);
                $Subgrupo->setDescricao($linha['DESCRICAO']);
                $Subgrupo->setDtRegistro($linha['DTREGISTRO']);
                $Subgrupo->setSituacao($linha['SITUACAO']);
                $lista[$c] = $Subgrupo;
                $c++;
            }
        }
        $this->Conexao->fecharConexao();
        return $lista;
    }
    
}