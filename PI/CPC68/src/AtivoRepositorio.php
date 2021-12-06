<?php
namespace src;

include_once 'Ativo.php';
include_once 'Grupo.php';
include_once 'Subgrupo.php';
include_once 'Ambiente.php';
include_once 'Funcionario.php'; include_once 'Cargo.php'; include_once 'Unidade.php';
include_once 'Conexao.php';

class AtivoRepositorio
{

    private $Conexao;

    public function __construct()
    {
        $this->Conexao = new Conexao();
    }
    
    public function cadastrarAtivo($Objeto) {
        $retorno = FALSE;
        $this->Conexao->abrirConexao();
        if ($this->Conexao->getConexao()->query(
            "INSERT INTO ATIVO(IDSUBGRUPO,IDAMBIENTE,IDFUNCIONARIO,NOME,DESCRICAO,CODIGOBARRA,ESTATUS,DTREGISTRO,SITUACAO) " .
            "VALUES(" .
            "    " . $Objeto->getSubgrupo()->getId() .
            ",   " . $Objeto->getAmbiente()->getId() .
            ",   " . $Objeto->getFuncionario()->getId() .
            ",  '" . $Objeto->getNome() .
            "', '" . $Objeto->getDescricao() .
            "', '" . $Objeto->getCodigoBarra() .
            "', 0" .
            " , NOW()" .
            ", 0);")) {
            $retorno = TRUE;
        } else {
            echo "Falha no cadastro do ativo. (REPOSITÓRIO)<br />";
        }
        $this->Conexao->fecharConexao();
        return $retorno;
    }
    
    public function alterarAtivo($Objeto)
    {
        $retorno = FALSE;
        $this->Conexao->abrirConexao();
        if ($this->Conexao->getConexao()->query(
            "UPDATE ATIVO SET" .
            "   IDSUBGRUPO = " . $Objeto->getSubgrupo()->getId() .
            " , NOME = '" . $Objeto->getNome() .
            "', DESCRICAO = '" . $Objeto->getDescricao() .
            "', CODIGOBARRA = " . $Objeto->getCodigoBarra() .
            "   WHERE ID = " . $Objeto->getId() . ";")) {
            $retorno = TRUE;
        } else {
            echo "Falha na alteração de cadastro do ativo. (REPOSITÓRIO)<br />";
        }
        $this->Conexao->fecharConexao();
        return $retorno;
    }
    
    public function existeAtivo($Objeto) {
        $retorno = FALSE;
        $this->Conexao->abrirConexao();
        $numeroLinhas = mysqli_num_rows($this->Conexao->getConexao()->query(
            "SELECT * FROM ATIVO" .
            " WHERE CODIGOBARRA = " . $Objeto->getCodigoBarra() . ";"));
        if ($numeroLinhas > 0) {
            $retorno = TRUE;
        }
        $this->Conexao->fecharConexao();
        return $retorno;
    }
    
    public function atualizarStatus($Objeto) {
        $retorno = FALSE;
        $this->Conexao->abrirConexao();
        if ($this->Conexao->getConexao()->query(
            "UPDATE ATIVO SET" .
            " ESTATUS = " . $Objeto->getStatus() .
            " WHERE ID = " . $Objeto->getId() . ";")) {
            $retorno = TRUE;
        } else {
            echo "Falha na atualização do ativo. (REPOSITÓRIO)<br />";
        }
        $this->Conexao->fecharConexao();
        return $retorno;
    }
    
    public function bloquearAtivo($Objeto) {
        $retorno = FALSE;
        $this->Conexao->abrirConexao();
        if ($this->Conexao->getConexao()->query(
            "UPDATE ATIVO SET" .
            " SITUACAO = 1" .
            " WHERE ID = " . $Objeto->getId() . ";")) {
            $retorno = TRUE;
        } else {
            echo "Falha no bloqueio do ativo. (REPOSITÓRIO)<br />";
        }
        $this->Conexao->fecharConexao();
        return $retorno;
    }
    
    public function desbloquearAtivo($Objeto) {
        $retorno = FALSE;
        $this->Conexao->abrirConexao();
        if ($this->Conexao->getConexao()->query(
            "UPDATE ATIVO SET" .
            " SITUACAO = 0" .
            " WHERE ID = " . $Objeto->getId() . ";")) {
            $retorno = TRUE;
        } else {
            echo "Falha no desbloqueio do ativo. (REPOSITÓRIO)<br />";
        }
        $this->Conexao->fecharConexao();
        return $retorno;
    }
    
    public function excluirAtivo($Objeto) {
        $retorno = FALSE;
        $this->Conexao->abrirConexao();
        if ($this->Conexao->getConexao()->query(
            "DELETE FROM ATIVO" .
            " WHERE ID = " . $Objeto->getId() . ";")) {
            $retorno = TRUE;
        } else {
            echo "Falha no exclusão do funcionário. (REPOSITÓRIO)<br />";
        }
        $this->Conexao->fecharConexao();
        return $retorno;
    }
    
    public function consultarAtivo($Objeto) {
        $this->Conexao->abrirConexao();
        $codigoSQL = "SELECT ATIVO.*, " .
            
            "GRUPO.ID AS GRUPOID, " .
            "GRUPO.NOME AS GRUPONOME, " .
            "GRUPO.DESCRICAO AS GRUPODESCRICAO, " .
            "GRUPO.DTREGISTRO AS GRUPODTREGISTRO, " .
            "GRUPO.SITUACAO AS GRUPOSITUACAO, " .
            
            "SUBGRUPO.ID AS SUBGRUPOID, " .
            "SUBGRUPO.IDGRUPO AS SUBGRUPOIDGRUPO, " .
            "SUBGRUPO.NOME AS SUBGRUPONOME, " .
            "SUBGRUPO.DESCRICAO AS SUBGRUPODESCRICAO, " .
            "SUBGRUPO.DTREGISTRO AS SUBGRUPODTREGISTRO, " .
            "SUBGRUPO.SITUACAO AS SUBGRUPOSITUACAO, " .
            
            "AMBIENTE.ID AS AMBIENTEID, " .
            "AMBIENTE.IDUNIDADE AS AMBIENTEIDUNIDADE, " .
            "AMBIENTE.NOME AS AMBIENTENOME, " .
            "AMBIENTE.CODIGOBARRA AS AMBIENTECODIGOBARRA, " .
            "AMBIENTE.DESCRICAO AS AMBIENTEDESCRICAO, " .
            "AMBIENTE.DTREGISTRO AS AMBIENTEDTREGISTRO, " .
            "AMBIENTE.SITUACAO AS AMBIENTESITUACAO, " .
            
            "UNIDADE.ID AS UNIDADEID, " .
            "UNIDADE.NOME AS UNIDADENOME, " .
            "UNIDADE.SIGLA AS UNIDADESIGLA, " .
            "UNIDADE.ENDERECO AS UNIDADEENDERECO, " .
            "UNIDADE.DTREGISTRO AS UNIDADEDTREGISTRO, " .
            "UNIDADE.SITUACAO AS UNIDADESITUACAO, " .
            
            "FUNCIONARIO.ID AS FUNCIONARIOID, " .
            "FUNCIONARIO.IDCARGO AS FUNCIONARIOIDCARGO, " .
            "FUNCIONARIO.IDUNIDADE AS FUNCIONARIOIDUNIDADE, " .
            "FUNCIONARIO.IDATORCADASTRO AS FUNCIONARIOIDATORCADASTRO, " .
            "FUNCIONARIO.NOME AS FUNCIONARIONOME, " .
            "FUNCIONARIO.TURNO AS FUNCIONAROTURNO, " .
            "FUNCIONARIO.NIVEL AS FUNCIONARIONIVEL, " .
            "FUNCIONARIO.DTREGISTRO AS FUNCIONARIODTREGISTRO, " .
            "FUNCIONARIO.SITUACAO AS FUNCIONARIOSITUACAO " .
            
            "FROM ATIVO, GRUPO, SUBGRUPO, AMBIENTE, FUNCIONARIO, UNIDADE " .
            "WHERE ATIVO.CODIGOBARRA = '" . $Objeto->getCodigoBarra() . "' " .
            "AND ATIVO.IDSUBGRUPO = SUBGRUPO.ID AND SUBGRUPO.IDGRUPO = GRUPO.ID " .
            "AND ATIVO.IDAMBIENTE = AMBIENTE.ID AND AMBIENTE.IDUNIDADE = UNIDADE.ID " .
            "AND ATIVO.IDFUNCIONARIO = FUNCIONARIO.ID " .
            ";";
        $numeroLinhas = mysqli_num_rows($this->Conexao->getConexao()->query($codigoSQL));
        if ($numeroLinhas > 0) {
            $linha = mysqli_fetch_assoc($this->Conexao->getConexao()->query($codigoSQL));
            $Objeto->setId($linha['ID']);
            
            $Subgrupo = new Subgrupo();
            $Subgrupo->setId($linha['SUBGRUPOID']);
            $Grupo = new Grupo();
            $Grupo->setId($linha['GRUPOID']);
            $Grupo->setNome($linha['GRUPONOME']);
            $Grupo->setDescricao($linha['GRUPODESCRICAO']);
            $Grupo->setDtRegistro($linha['GRUPODTREGISTRO']);
            $Grupo->setSituacao($linha['GRUPOSITUACAO']);
            $Subgrupo->setGrupo($Grupo);
            $Subgrupo->setNome($linha['SUBGRUPONOME']);
            $Subgrupo->setDescricao($linha['SUBGRUPODESCRICAO']);
            $Subgrupo->setSituacao($linha['SUBGRUPOSITUACAO']);
            $Objeto->setSubgrupo($Subgrupo);
            
            
            $Ambiente = new Ambiente();
            $Ambiente->setId($linha['AMBIENTEID']);
            $UnidadeAmb = new Unidade();
            $UnidadeAmb->setId($linha['AMBIENTEIDUNIDADE']);
            $UnidadeAmb->setNome($linha['UNIDADENOME']);
            $UnidadeAmb->setSigla($linha['UNIDADESIGLA']);
            $UnidadeAmb->setEndereco($linha['UNIDADEENDERECO']);
            $UnidadeAmb->setDtRegistro($linha['UNIDADEDTREGISTRO']);
            $UnidadeAmb->setSituacao($linha['UNIDADESITUACAO']);
            $Ambiente->setUnidade($UnidadeAmb);
            $Ambiente->setNome($linha['AMBIENTENOME']);
            $Ambiente->setCodigoBarra($linha['AMBIENTECODIGOBARRA']);
            $Ambiente->setDescricao($linha['AMBIENTEDESCRICAO']);
            $Ambiente->setDtRegistro($linha['AMBIENTEDTREGISTRO']);
            $Ambiente->setSituacao($linha['AMBIENTESITUACAO']);
            $Objeto->setAmbiente($Ambiente);
                
            $Funcionario = new Funcionario();
            $Funcionario->setId($linha['FUNCIONARIOID']);
            $Cargo = new Cargo();
            $Cargo->setId($linha['FUNCIONARIOIDCARGO']);
            $Funcionario->setCargo($Cargo);
            $UnidadeFunc = new Unidade();
            $UnidadeFunc->setId($linha['FUNCIONARIOIDUNIDADE']);
            $Funcionario->setUnidade($UnidadeFunc);
            $Funcionario->setIdAtorCadastro($linha['FUNCIONARIOIDATORCADASTRO']);
            $Funcionario->setNome($linha['FUNCIONARIONOME']);
            $Funcionario->setTurno($linha['FUNCIONAROTURNO']);
            $Funcionario->setNivel($linha['FUNCIONARIONIVEL']);
            $Funcionario->setDtRegistro($linha['FUNCIONARIODTREGISTRO']);
            $Funcionario->setSituacao($linha['FUNCIONARIOSITUACAO']);
            $Objeto->setFuncionario($Funcionario);
            
            $Objeto->setNome($linha['NOME']);
            $Objeto->setDescricao($linha['DESCRICAO']);
            $Objeto->setCodigoBarra($linha['CODIGOBARRA']);
            $Objeto->setStatus($linha['ESTATUS']);
            $Objeto->setDtRegistro($linha['DTREGISTRO']);
            $Objeto->setSituacao($linha['SITUACAO']);
        }
        $this->Conexao->fecharConexao();
        return $Objeto;
    }
    
    public function contarAtivo() {
        $quantidade = 0;
        $this->Conexao->abrirConexao();
        $resultado = $this->Conexao->getConexao()->query(
            "SELECT COUNT(ID) AS QUANTIDADE FROM ATIVO;"
            );
        $numeroLinhas = mysqli_num_rows($resultado);
        if ($numeroLinhas > 0) {
            $linha = mysqli_fetch_assoc($resultado);
            $quantidade = $linha['QUANTIDADE'];
        }
        $this->Conexao->fecharConexao();
        return $quantidade;
    }
    
    public function contarAtivoPorAmbiente($idAmbiente) {
        $quantidade = 0;
        $this->Conexao->abrirConexao();
        $resultado = $this->Conexao->getConexao()->query(
            "SELECT COUNT(ID) AS QUANTIDADE FROM ATIVO WHERE IDAMBIENTE = " . $idAmbiente . ";");
        $numeroLinhas = mysqli_num_rows($resultado);
        if ($numeroLinhas > 0) {
            $linha = mysqli_fetch_assoc($resultado);
            $quantidade = $linha['QUANTIDADE'];
        }
        $this->Conexao->fecharConexao();
        return $quantidade;
    }
    
    public function contarAtivoPorAmbienteDesbloqueado($idAmbiente) {
        $quantidade = 0;
        $this->Conexao->abrirConexao();
        $resultado = $this->Conexao->getConexao()->query(
            "SELECT COUNT(ID) AS QUANTIDADE FROM ATIVO WHERE IDAMBIENTE = " . $idAmbiente . " AND SITUACAO = 0;");
        $numeroLinhas = mysqli_num_rows($resultado);
        if ($numeroLinhas > 0) {
            $linha = mysqli_fetch_assoc($resultado);
            $quantidade = $linha['QUANTIDADE'];
        }
        $this->Conexao->fecharConexao();
        return $quantidade;
    }
    
    public function listarAtivo() {
        $lista = null;
        $this->Conexao->abrirConexao();
        $resultado = $this->Conexao->getConexao()->query(
            "SELECT ATIVO.*" .
            ", GRUPO.NOME AS NOMEGRUPO" .
            ", SUBGRUPO.IDGRUPO AS SUBGRUPOIDGRUPO" .
            ", SUBGRUPO.NOME AS NOMESUBGRUPO" .
            ", FUNCIONARIO.NOME AS NOMEFUNCIONARIO" .
            ", AMBIENTE.NOME AS NOMEAMBIENTE" .
            " FROM ATIVO, GRUPO, SUBGRUPO, FUNCIONARIO, AMBIENTE" .
            " WHERE SUBGRUPO.IDGRUPO = GRUPO.ID AND ATIVO.IDSUBGRUPO = SUBGRUPO.ID AND ATIVO.IDFUNCIONARIO = FUNCIONARIO.ID AND ATIVO.IDAMBIENTE = AMBIENTE.ID" .
            " ORDER BY ATIVO.DTREGISTRO DESC;");
        $numeroLinhas = mysqli_num_rows($resultado);
        if ($numeroLinhas > 0) {
            $c = 0;
            while ($linha = mysqli_fetch_assoc($resultado)) {
                $Ativo = new Ativo();
                $Ativo->setId($linha['ID']);
                $Subgrupo = new Subgrupo();
                $Subgrupo->setId($linha['IDSUBGRUPO']);
                $Grupo = new Grupo();
                $Grupo->setId($linha['SUBGRUPOIDGRUPO']);
                $Grupo->setNome($linha['NOMEGRUPO']);
                $Subgrupo->setGrupo($Grupo);
                $Subgrupo->setNome($linha['NOMESUBGRUPO']);
                $Ativo->setSubgrupo($Subgrupo);
                $Ambiente = new Ambiente();
                $Ambiente->setId($linha['IDAMBIENTE']);
                $Ambiente->setNome($linha['NOMEAMBIENTE']);
                $Ativo->setAmbiente($Ambiente);
                $Funcionario = new Funcionario();
                $Funcionario->setId($linha['IDFUNCIONARIO']);
                $Funcionario->setNome($linha['NOMEFUNCIONARIO']);
                $Ativo->setFuncionario($Funcionario);
                $Ativo->setNome($linha['NOME']);
                $Ativo->setDescricao($linha['DESCRICAO']);
                $Ativo->setStatus($linha['ESTATUS']);
                $Ativo->setCodigoBarra($linha['CODIGOBARRA']);
                $Ativo->setDtRegistro($linha['DTREGISTRO']);
                $Ativo->setSituacao($linha['SITUACAO']);
                $lista[$c] = $Ativo;
                $c++;
            }
        }
        $this->Conexao->fecharConexao();
        return $lista;
    }
    
    public function listarAtivoPorAmbiente($idAmbiente) {
        $lista = null;
        $this->Conexao->abrirConexao();
        $resultado = $this->Conexao->getConexao()->query(
            "SELECT ATIVO.*" .
            ", GRUPO.NOME AS NOMEGRUPO" .
            ", SUBGRUPO.IDGRUPO AS SUBGRUPOIDGRUPO" .
            ", SUBGRUPO.NOME AS NOMESUBGRUPO" .
            ", FUNCIONARIO.NOME AS NOMEFUNCIONARIO" .
            ", AMBIENTE.NOME AS NOMEAMBIENTE" .
            " FROM ATIVO, GRUPO, SUBGRUPO, FUNCIONARIO, AMBIENTE" .
            " WHERE ATIVO.IDAMBIENTE = " . $idAmbiente . " AND SUBGRUPO.IDGRUPO = GRUPO.ID AND ATIVO.IDSUBGRUPO = SUBGRUPO.ID AND ATIVO.IDFUNCIONARIO = FUNCIONARIO.ID AND ATIVO.IDAMBIENTE = AMBIENTE.ID" .
            " ORDER BY ATIVO.DTREGISTRO DESC;");
        $numeroLinhas = mysqli_num_rows($resultado);
        if ($numeroLinhas > 0) {
            $c = 0;
            while ($linha = mysqli_fetch_assoc($resultado)) {
                $Ativo = new Ativo();
                $Ativo->setId($linha['ID']);
                $Subgrupo = new Subgrupo();
                $Subgrupo->setId($linha['IDSUBGRUPO']);
                $Grupo = new Grupo();
                $Grupo->setId($linha['SUBGRUPOIDGRUPO']);
                $Grupo->setNome($linha['NOMEGRUPO']);
                $Subgrupo->setGrupo($Grupo);
                $Subgrupo->setNome($linha['NOMESUBGRUPO']);
                $Ativo->setSubgrupo($Subgrupo);
                $Ambiente = new Ambiente();
                $Ambiente->setId($linha['IDAMBIENTE']);
                $Ambiente->setNome($linha['NOMEAMBIENTE']);
                $Ativo->setAmbiente($Ambiente);
                $Funcionario = new Funcionario();
                $Funcionario->setId($linha['IDFUNCIONARIO']);
                $Funcionario->setNome($linha['NOMEFUNCIONARIO']);
                $Ativo->setFuncionario($Funcionario);
                $Ativo->setNome($linha['NOME']);
                $Ativo->setDescricao($linha['DESCRICAO']);
                $Ativo->setCodigoBarra($linha['CODIGOBARRA']);
                $Ativo->setStatus($linha['ESTATUS']);
                $Ativo->setDtRegistro($linha['DTREGISTRO']);
                $Ativo->setSituacao($linha['SITUACAO']);
                $lista[$c] = $Ativo;
                $c++;
            }
        }
        $this->Conexao->fecharConexao();
        return $lista;
    }
    
    public function listarAtivoPorAmbienteDesbloqueado($idAmbiente) {
        $lista = null;
        $this->Conexao->abrirConexao();
        $resultado = $this->Conexao->getConexao()->query(
            "SELECT ATIVO.*" .
            ", GRUPO.NOME AS NOMEGRUPO" .
            ", SUBGRUPO.IDGRUPO AS SUBGRUPOIDGRUPO" .
            ", SUBGRUPO.NOME AS NOMESUBGRUPO" .
            ", FUNCIONARIO.NOME AS NOMEFUNCIONARIO" .
            ", AMBIENTE.NOME AS NOMEAMBIENTE" .
            " FROM ATIVO, GRUPO, SUBGRUPO, FUNCIONARIO, AMBIENTE" .
            " WHERE ATIVO.IDAMBIENTE = " . $idAmbiente . " AND SUBGRUPO.IDGRUPO = GRUPO.ID AND ATIVO.IDSUBGRUPO = SUBGRUPO.ID AND ATIVO.IDFUNCIONARIO = FUNCIONARIO.ID AND ATIVO.IDAMBIENTE = AMBIENTE.ID AND ATIVO.SITUACAO = 0" .
            " ORDER BY ATIVO.DTREGISTRO DESC;");
        $numeroLinhas = mysqli_num_rows($resultado);
        if ($numeroLinhas > 0) {
            $c = 0;
            while ($linha = mysqli_fetch_assoc($resultado)) {
                $Ativo = new Ativo();
                $Ativo->setId($linha['ID']);
                $Subgrupo = new Subgrupo();
                $Subgrupo->setId($linha['IDSUBGRUPO']);
                $Grupo = new Grupo();
                $Grupo->setId($linha['SUBGRUPOIDGRUPO']);
                $Grupo->setNome($linha['NOMEGRUPO']);
                $Subgrupo->setGrupo($Grupo);
                $Subgrupo->setNome($linha['NOMESUBGRUPO']);
                $Ativo->setSubgrupo($Subgrupo);
                $Ambiente = new Ambiente();
                $Ambiente->setId($linha['IDAMBIENTE']);
                $Ambiente->setNome($linha['NOMEAMBIENTE']);
                $Ativo->setAmbiente($Ambiente);
                $Funcionario = new Funcionario();
                $Funcionario->setId($linha['IDFUNCIONARIO']);
                $Funcionario->setNome($linha['NOMEFUNCIONARIO']);
                $Ativo->setFuncionario($Funcionario);
                $Ativo->setNome($linha['NOME']);
                $Ativo->setDescricao($linha['DESCRICAO']);
                $Ativo->setStatus($linha['ESTATUS']);
                $Ativo->setCodigoBarra($linha['CODIGOBARRA']);
                $Ativo->setDtRegistro($linha['DTREGISTRO']);
                $Ativo->setSituacao($linha['SITUACAO']);
                $lista[$c] = $Ativo;
                $c++;
            }
        }
        $this->Conexao->fecharConexao();
        return $lista;
    }
    
    
    
    
    
    
// =====================================RELATÓRIOS==================================
    
    
    public function relContarAtivosDaUnidade($idUnidade) {
        $quantidade = 0;
        $this->Conexao->abrirConexao();
        $resultado = $this->Conexao->getConexao()->query(
            "SELECT COUNT(ATIVO.ID) AS QUANTIDADE FROM ATIVO, UNIDADE, AMBIENTE " .
            "WHERE " .
            "UNIDADE.ID = " . $idUnidade . " " .
            "AND AMBIENTE.ID = ATIVO.IDAMBIENTE " .
            "AND UNIDADE.ID = AMBIENTE.IDUNIDADE;"
            );
        $numeroLinhas = mysqli_num_rows($resultado);
        if ($numeroLinhas > 0) {
            $linha = mysqli_fetch_assoc($resultado);
            $quantidade = $linha['QUANTIDADE'];
        }
        $this->Conexao->fecharConexao();
        return $quantidade;
    }
    
    public function relListarAtivosDaUnidade($idUnidade) {
        $lista = null;
        $this->Conexao->abrirConexao();
        $resultado = $this->Conexao->getConexao()->query(
            "SELECT ATIVO.*" .
            ", GRUPO.NOME AS NOMEGRUPO" .
            ", SUBGRUPO.IDGRUPO AS SUBGRUPOIDGRUPO" .
            ", SUBGRUPO.NOME AS NOMESUBGRUPO" .
            ", FUNCIONARIO.NOME AS NOMEFUNCIONARIO" .
            ", AMBIENTE.NOME AS NOMEAMBIENTE" .
            ", UNIDADE.NOME AS UNIDADENOME" .
            " FROM ATIVO, GRUPO, SUBGRUPO, FUNCIONARIO, AMBIENTE, UNIDADE" .
            " WHERE UNIDADE.ID = " . $idUnidade . " AND SUBGRUPO.IDGRUPO = GRUPO.ID AND ATIVO.IDSUBGRUPO = SUBGRUPO.ID AND ATIVO.IDFUNCIONARIO = FUNCIONARIO.ID AND ATIVO.IDAMBIENTE = AMBIENTE.ID AND AMBIENTE.IDUNIDADE = UNIDADE.ID" .
            " ORDER BY ATIVO.NOME DESC;");
        $numeroLinhas = mysqli_num_rows($resultado);
        if ($numeroLinhas > 0) {
            $c = 0;
            while ($linha = mysqli_fetch_assoc($resultado)) {
                $Ativo = new Ativo();
                $Ativo->setId($linha['ID']);
                $Subgrupo = new Subgrupo();
                $Subgrupo->setId($linha['IDSUBGRUPO']);
                $Grupo = new Grupo();
                $Grupo->setId($linha['SUBGRUPOIDGRUPO']);
                $Grupo->setNome($linha['NOMEGRUPO']);
                $Subgrupo->setGrupo($Grupo);
                $Subgrupo->setNome($linha['NOMESUBGRUPO']);
                $Ativo->setSubgrupo($Subgrupo);
                $Ambiente = new Ambiente();
                $Unidade = new Unidade();
                $Unidade->setNome($linha['UNIDADENOME']);
                $Ambiente->setUnidade($Unidade);
                $Ambiente->setId($linha['IDAMBIENTE']);
                $Ambiente->setNome($linha['NOMEAMBIENTE']);
                $Ativo->setAmbiente($Ambiente);
                $Funcionario = new Funcionario();
                $Funcionario->setId($linha['IDFUNCIONARIO']);
                $Funcionario->setNome($linha['NOMEFUNCIONARIO']);
                $Ativo->setFuncionario($Funcionario);
                $Ativo->setNome($linha['NOME']);
                $Ativo->setDescricao($linha['DESCRICAO']);
                $Ativo->setStatus($linha['ESTATUS']);
                $Ativo->setCodigoBarra($linha['CODIGOBARRA']);
                $Ativo->setDtRegistro($linha['DTREGISTRO']);
                $Ativo->setSituacao($linha['SITUACAO']);
                $lista[$c] = $Ativo;
                $c++;
            }
        }
        $this->Conexao->fecharConexao();
        return $lista;
    }
    
    public function relContarAtivosMalFunc($idUnidade) {
        $quantidade = 0;
        $this->Conexao->abrirConexao();
        $resultado = $this->Conexao->getConexao()->query(
            "SELECT COUNT(ATIVO.ID) AS QUANTIDADE FROM ATIVO, UNIDADE, AMBIENTE " .
            "WHERE ATIVO.ESTATUS = 10 " .
            "AND UNIDADE.ID = " . $idUnidade . " " .
            "AND AMBIENTE.ID = ATIVO.IDAMBIENTE " .
            "AND UNIDADE.ID = AMBIENTE.IDUNIDADE;"
            );
        $numeroLinhas = mysqli_num_rows($resultado);
        if ($numeroLinhas > 0) {
            $linha = mysqli_fetch_assoc($resultado);
            $quantidade = $linha['QUANTIDADE'];
        }
        $this->Conexao->fecharConexao();
        return $quantidade;
    }
    
    public function relListarAtivosMalFunc($idUnidade) {
        $lista = null;
        $this->Conexao->abrirConexao();
        $resultado = $this->Conexao->getConexao()->query(
            "SELECT ATIVO.*" .
            ", GRUPO.NOME AS NOMEGRUPO" .
            ", SUBGRUPO.IDGRUPO AS SUBGRUPOIDGRUPO" .
            ", SUBGRUPO.NOME AS NOMESUBGRUPO" .
            ", FUNCIONARIO.NOME AS NOMEFUNCIONARIO" .
            ", AMBIENTE.NOME AS NOMEAMBIENTE" .
            ", UNIDADE.NOME AS UNIDADENOME" .
            " FROM ATIVO, GRUPO, SUBGRUPO, FUNCIONARIO, AMBIENTE, UNIDADE" .
            " WHERE ATIVO.ESTATUS = 10 AND UNIDADE.ID = " . $idUnidade . " AND SUBGRUPO.IDGRUPO = GRUPO.ID AND ATIVO.IDSUBGRUPO = SUBGRUPO.ID AND ATIVO.IDFUNCIONARIO = FUNCIONARIO.ID AND ATIVO.IDAMBIENTE = AMBIENTE.ID AND AMBIENTE.IDUNIDADE = UNIDADE.ID" .
            " ORDER BY ATIVO.NOME DESC;");
        $numeroLinhas = mysqli_num_rows($resultado);
        if ($numeroLinhas > 0) {
            $c = 0;
            while ($linha = mysqli_fetch_assoc($resultado)) {
                $Ativo = new Ativo();
                $Ativo->setId($linha['ID']);
                $Subgrupo = new Subgrupo();
                $Subgrupo->setId($linha['IDSUBGRUPO']);
                $Grupo = new Grupo();
                $Grupo->setId($linha['SUBGRUPOIDGRUPO']);
                $Grupo->setNome($linha['NOMEGRUPO']);
                $Subgrupo->setGrupo($Grupo);
                $Subgrupo->setNome($linha['NOMESUBGRUPO']);
                $Ativo->setSubgrupo($Subgrupo);
                $Ambiente = new Ambiente();
                $Unidade = new Unidade();
                $Unidade->setNome($linha['UNIDADENOME']);
                $Ambiente->setUnidade($Unidade);
                $Ambiente->setId($linha['IDAMBIENTE']);
                $Ambiente->setNome($linha['NOMEAMBIENTE']);
                $Ativo->setAmbiente($Ambiente);
                $Funcionario = new Funcionario();
                $Funcionario->setId($linha['IDFUNCIONARIO']);
                $Funcionario->setNome($linha['NOMEFUNCIONARIO']);
                $Ativo->setFuncionario($Funcionario);
                $Ativo->setNome($linha['NOME']);
                $Ativo->setDescricao($linha['DESCRICAO']);
                $Ativo->setStatus($linha['ESTATUS']);
                $Ativo->setCodigoBarra($linha['CODIGOBARRA']);
                $Ativo->setDtRegistro($linha['DTREGISTRO']);
                $Ativo->setSituacao($linha['SITUACAO']);
                $lista[$c] = $Ativo;
                $c++;
            }
        }
        $this->Conexao->fecharConexao();
        return $lista;
    }
    
    public function relContarAtivosQuebrados($idUnidade) {
        $quantidade = 0;
        $this->Conexao->abrirConexao();
        $resultado = $this->Conexao->getConexao()->query(
            "SELECT COUNT(ATIVO.ID) AS QUANTIDADE FROM ATIVO, UNIDADE, AMBIENTE " .
            "WHERE ATIVO.ESTATUS = 11 " .
            "AND UNIDADE.ID = " . $idUnidade . " " .
            "AND AMBIENTE.ID = ATIVO.IDAMBIENTE " .
            "AND UNIDADE.ID = AMBIENTE.IDUNIDADE;"
            );
        $numeroLinhas = mysqli_num_rows($resultado);
        if ($numeroLinhas > 0) {
            $linha = mysqli_fetch_assoc($resultado);
            $quantidade = $linha['QUANTIDADE'];
        }
        $this->Conexao->fecharConexao();
        return $quantidade;
    }
    
    public function relListarAtivosQuebrados($idUnidade) {
        $lista = null;
        $this->Conexao->abrirConexao();
        $resultado = $this->Conexao->getConexao()->query(
            "SELECT ATIVO.*" .
            ", GRUPO.NOME AS NOMEGRUPO" .
            ", SUBGRUPO.IDGRUPO AS SUBGRUPOIDGRUPO" .
            ", SUBGRUPO.NOME AS NOMESUBGRUPO" .
            ", FUNCIONARIO.NOME AS NOMEFUNCIONARIO" .
            ", AMBIENTE.NOME AS NOMEAMBIENTE" .
            ", UNIDADE.NOME AS UNIDADENOME" .
            " FROM ATIVO, GRUPO, SUBGRUPO, FUNCIONARIO, AMBIENTE, UNIDADE" .
            " WHERE ATIVO.ESTATUS = 11 AND UNIDADE.ID = " . $idUnidade . " AND SUBGRUPO.IDGRUPO = GRUPO.ID AND ATIVO.IDSUBGRUPO = SUBGRUPO.ID AND ATIVO.IDFUNCIONARIO = FUNCIONARIO.ID AND ATIVO.IDAMBIENTE = AMBIENTE.ID AND AMBIENTE.IDUNIDADE = UNIDADE.ID" .
            " ORDER BY ATIVO.NOME DESC;");
        $numeroLinhas = mysqli_num_rows($resultado);
        if ($numeroLinhas > 0) {
            $c = 0;
            while ($linha = mysqli_fetch_assoc($resultado)) {
                $Ativo = new Ativo();
                $Ativo->setId($linha['ID']);
                $Subgrupo = new Subgrupo();
                $Subgrupo->setId($linha['IDSUBGRUPO']);
                $Grupo = new Grupo();
                $Grupo->setId($linha['SUBGRUPOIDGRUPO']);
                $Grupo->setNome($linha['NOMEGRUPO']);
                $Subgrupo->setGrupo($Grupo);
                $Subgrupo->setNome($linha['NOMESUBGRUPO']);
                $Ativo->setSubgrupo($Subgrupo);
                $Ambiente = new Ambiente();
                $Unidade = new Unidade();
                $Unidade->setNome($linha['UNIDADENOME']);
                $Ambiente->setUnidade($Unidade);
                $Ambiente->setId($linha['IDAMBIENTE']);
                $Ambiente->setNome($linha['NOMEAMBIENTE']);
                $Ativo->setAmbiente($Ambiente);
                $Funcionario = new Funcionario();
                $Funcionario->setId($linha['IDFUNCIONARIO']);
                $Funcionario->setNome($linha['NOMEFUNCIONARIO']);
                $Ativo->setFuncionario($Funcionario);
                $Ativo->setNome($linha['NOME']);
                $Ativo->setDescricao($linha['DESCRICAO']);
                $Ativo->setStatus($linha['ESTATUS']);
                $Ativo->setCodigoBarra($linha['CODIGOBARRA']);
                $Ativo->setDtRegistro($linha['DTREGISTRO']);
                $Ativo->setSituacao($linha['SITUACAO']);
                $lista[$c] = $Ativo;
                $c++;
            }
        }
        $this->Conexao->fecharConexao();
        return $lista;
    }
    
    public function relContarAtivosSemTomb($idUnidade) {
        $quantidade = 0;
        $this->Conexao->abrirConexao();
        $resultado = $this->Conexao->getConexao()->query(
            "SELECT COUNT(ATIVO.ID) AS QUANTIDADE FROM ATIVO, UNIDADE, AMBIENTE " .
            "WHERE ATIVO.ESTATUS = 12 " .
            "AND UNIDADE.ID = " . $idUnidade . " " .
            "AND AMBIENTE.ID = ATIVO.IDAMBIENTE " .
            "AND UNIDADE.ID = AMBIENTE.IDUNIDADE;"
            );
        $numeroLinhas = mysqli_num_rows($resultado);
        if ($numeroLinhas > 0) {
            $linha = mysqli_fetch_assoc($resultado);
            $quantidade = $linha['QUANTIDADE'];
        }
        $this->Conexao->fecharConexao();
        return $quantidade;
    }
    
    public function relListarAtivosSemTomb($idUnidade) {
        $lista = null;
        $this->Conexao->abrirConexao();
        $resultado = $this->Conexao->getConexao()->query(
            "SELECT ATIVO.*" .
            ", GRUPO.NOME AS NOMEGRUPO" .
            ", SUBGRUPO.IDGRUPO AS SUBGRUPOIDGRUPO" .
            ", SUBGRUPO.NOME AS NOMESUBGRUPO" .
            ", FUNCIONARIO.NOME AS NOMEFUNCIONARIO" .
            ", AMBIENTE.NOME AS NOMEAMBIENTE" .
            ", UNIDADE.NOME AS UNIDADENOME" .
            " FROM ATIVO, GRUPO, SUBGRUPO, FUNCIONARIO, AMBIENTE, UNIDADE" .
            " WHERE ATIVO.ESTATUS = 12 AND UNIDADE.ID = " . $idUnidade . " AND SUBGRUPO.IDGRUPO = GRUPO.ID AND ATIVO.IDSUBGRUPO = SUBGRUPO.ID AND ATIVO.IDFUNCIONARIO = FUNCIONARIO.ID AND ATIVO.IDAMBIENTE = AMBIENTE.ID AND AMBIENTE.IDUNIDADE = UNIDADE.ID" .
            " ORDER BY ATIVO.NOME DESC;");
        $numeroLinhas = mysqli_num_rows($resultado);
        if ($numeroLinhas > 0) {
            $c = 0;
            while ($linha = mysqli_fetch_assoc($resultado)) {
                $Ativo = new Ativo();
                $Ativo->setId($linha['ID']);
                $Subgrupo = new Subgrupo();
                $Subgrupo->setId($linha['IDSUBGRUPO']);
                $Grupo = new Grupo();
                $Grupo->setId($linha['SUBGRUPOIDGRUPO']);
                $Grupo->setNome($linha['NOMEGRUPO']);
                $Subgrupo->setGrupo($Grupo);
                $Subgrupo->setNome($linha['NOMESUBGRUPO']);
                $Ativo->setSubgrupo($Subgrupo);
                $Ambiente = new Ambiente();
                $Unidade = new Unidade();
                $Unidade->setNome($linha['UNIDADENOME']);
                $Ambiente->setUnidade($Unidade);
                $Ambiente->setId($linha['IDAMBIENTE']);
                $Ambiente->setNome($linha['NOMEAMBIENTE']);
                $Ativo->setAmbiente($Ambiente);
                $Funcionario = new Funcionario();
                $Funcionario->setId($linha['IDFUNCIONARIO']);
                $Funcionario->setNome($linha['NOMEFUNCIONARIO']);
                $Ativo->setFuncionario($Funcionario);
                $Ativo->setNome($linha['NOME']);
                $Ativo->setDescricao($linha['DESCRICAO']);
                $Ativo->setStatus($linha['ESTATUS']);
                $Ativo->setCodigoBarra($linha['CODIGOBARRA']);
                $Ativo->setDtRegistro($linha['DTREGISTRO']);
                $Ativo->setSituacao($linha['SITUACAO']);
                $lista[$c] = $Ativo;
                $c++;
            }
        }
        $this->Conexao->fecharConexao();
        return $lista;
    }
    
    public function relContarAtivosAusentes($idUnidade) {
        $quantidade = 0;
        $this->Conexao->abrirConexao();
        $resultado = $this->Conexao->getConexao()->query(
            "SELECT COUNT(ATIVO.ID) AS QUANTIDADE FROM ATIVO, UNIDADE, AMBIENTE " .
            "WHERE ATIVO.ESTATUS = 13 " .
            "AND UNIDADE.ID = " . $idUnidade . " " .
            "AND AMBIENTE.ID = ATIVO.IDAMBIENTE " .
            "AND UNIDADE.ID = AMBIENTE.IDUNIDADE;"
            );
        $numeroLinhas = mysqli_num_rows($resultado);
        if ($numeroLinhas > 0) {
            $linha = mysqli_fetch_assoc($resultado);
            $quantidade = $linha['QUANTIDADE'];
        }
        $this->Conexao->fecharConexao();
        return $quantidade;
    }
    
    public function relListarAtivosAusentes($idUnidade) {
        $lista = null;
        $this->Conexao->abrirConexao();
        $resultado = $this->Conexao->getConexao()->query(
            "SELECT ATIVO.*" .
            ", GRUPO.NOME AS NOMEGRUPO" .
            ", SUBGRUPO.IDGRUPO AS SUBGRUPOIDGRUPO" .
            ", SUBGRUPO.NOME AS NOMESUBGRUPO" .
            ", FUNCIONARIO.NOME AS NOMEFUNCIONARIO" .
            ", AMBIENTE.NOME AS NOMEAMBIENTE" .
            ", UNIDADE.NOME AS UNIDADENOME" .
            " FROM ATIVO, GRUPO, SUBGRUPO, FUNCIONARIO, AMBIENTE, UNIDADE" .
            " WHERE ATIVO.ESTATUS = 13 AND UNIDADE.ID = " . $idUnidade . " AND SUBGRUPO.IDGRUPO = GRUPO.ID AND ATIVO.IDSUBGRUPO = SUBGRUPO.ID AND ATIVO.IDFUNCIONARIO = FUNCIONARIO.ID AND ATIVO.IDAMBIENTE = AMBIENTE.ID AND AMBIENTE.IDUNIDADE = UNIDADE.ID" .
            " ORDER BY ATIVO.NOME DESC;");
        $numeroLinhas = mysqli_num_rows($resultado);
        if ($numeroLinhas > 0) {
            $c = 0;
            while ($linha = mysqli_fetch_assoc($resultado)) {
                $Ativo = new Ativo();
                $Ativo->setId($linha['ID']);
                $Subgrupo = new Subgrupo();
                $Subgrupo->setId($linha['IDSUBGRUPO']);
                $Grupo = new Grupo();
                $Grupo->setId($linha['SUBGRUPOIDGRUPO']);
                $Grupo->setNome($linha['NOMEGRUPO']);
                $Subgrupo->setGrupo($Grupo);
                $Subgrupo->setNome($linha['NOMESUBGRUPO']);
                $Ativo->setSubgrupo($Subgrupo);
                $Ambiente = new Ambiente();
                $Unidade = new Unidade();
                $Unidade->setNome($linha['UNIDADENOME']);
                $Ambiente->setUnidade($Unidade);
                $Ambiente->setId($linha['IDAMBIENTE']);
                $Ambiente->setNome($linha['NOMEAMBIENTE']);
                $Ativo->setAmbiente($Ambiente);
                $Funcionario = new Funcionario();
                $Funcionario->setId($linha['IDFUNCIONARIO']);
                $Funcionario->setNome($linha['NOMEFUNCIONARIO']);
                $Ativo->setFuncionario($Funcionario);
                $Ativo->setNome($linha['NOME']);
                $Ativo->setDescricao($linha['DESCRICAO']);
                $Ativo->setStatus($linha['ESTATUS']);
                $Ativo->setCodigoBarra($linha['CODIGOBARRA']);
                $Ativo->setDtRegistro($linha['DTREGISTRO']);
                $Ativo->setSituacao($linha['SITUACAO']);
                $lista[$c] = $Ativo;
                $c++;
            }
        }
        $this->Conexao->fecharConexao();
        return $lista;
    }
    
    public function relContarAtivosAssTec($idUnidade) {
        $quantidade = 0;
        $this->Conexao->abrirConexao();
        $resultado = $this->Conexao->getConexao()->query(
            "SELECT COUNT(ATIVO.ID) AS QUANTIDADE FROM ATIVO, UNIDADE, AMBIENTE " .
            "WHERE ATIVO.ESTATUS = 2 " .
            "AND UNIDADE.ID = " . $idUnidade . " " .
            "AND AMBIENTE.ID = ATIVO.IDAMBIENTE " .
            "AND UNIDADE.ID = AMBIENTE.IDUNIDADE;"
            );
        $numeroLinhas = mysqli_num_rows($resultado);
        if ($numeroLinhas > 0) {
            $linha = mysqli_fetch_assoc($resultado);
            $quantidade = $linha['QUANTIDADE'];
        }
        $this->Conexao->fecharConexao();
        return $quantidade;
    }
    
    public function relListarAtivosAssTec($idUnidade) {
        $lista = null;
        $this->Conexao->abrirConexao();
        $resultado = $this->Conexao->getConexao()->query(
            "SELECT ATIVO.*" .
            ", GRUPO.NOME AS NOMEGRUPO" .
            ", SUBGRUPO.IDGRUPO AS SUBGRUPOIDGRUPO" .
            ", SUBGRUPO.NOME AS NOMESUBGRUPO" .
            ", FUNCIONARIO.NOME AS NOMEFUNCIONARIO" .
            ", AMBIENTE.NOME AS NOMEAMBIENTE" .
            ", UNIDADE.NOME AS UNIDADENOME" .
            " FROM ATIVO, GRUPO, SUBGRUPO, FUNCIONARIO, AMBIENTE, UNIDADE" .
            " WHERE ATIVO.ESTATUS = 2 AND UNIDADE.ID = " . $idUnidade . " AND SUBGRUPO.IDGRUPO = GRUPO.ID AND ATIVO.IDSUBGRUPO = SUBGRUPO.ID AND ATIVO.IDFUNCIONARIO = FUNCIONARIO.ID AND ATIVO.IDAMBIENTE = AMBIENTE.ID AND AMBIENTE.IDUNIDADE = UNIDADE.ID" .
            " ORDER BY ATIVO.NOME DESC;");
        $numeroLinhas = mysqli_num_rows($resultado);
        if ($numeroLinhas > 0) {
            $c = 0;
            while ($linha = mysqli_fetch_assoc($resultado)) {
                $Ativo = new Ativo();
                $Ativo->setId($linha['ID']);
                $Subgrupo = new Subgrupo();
                $Subgrupo->setId($linha['IDSUBGRUPO']);
                $Grupo = new Grupo();
                $Grupo->setId($linha['SUBGRUPOIDGRUPO']);
                $Grupo->setNome($linha['NOMEGRUPO']);
                $Subgrupo->setGrupo($Grupo);
                $Subgrupo->setNome($linha['NOMESUBGRUPO']);
                $Ativo->setSubgrupo($Subgrupo);
                $Ambiente = new Ambiente();
                $Unidade = new Unidade();
                $Unidade->setNome($linha['UNIDADENOME']);
                $Ambiente->setUnidade($Unidade);
                $Ambiente->setId($linha['IDAMBIENTE']);
                $Ambiente->setNome($linha['NOMEAMBIENTE']);
                $Ativo->setAmbiente($Ambiente);
                $Funcionario = new Funcionario();
                $Funcionario->setId($linha['IDFUNCIONARIO']);
                $Funcionario->setNome($linha['NOMEFUNCIONARIO']);
                $Ativo->setFuncionario($Funcionario);
                $Ativo->setNome($linha['NOME']);
                $Ativo->setDescricao($linha['DESCRICAO']);
                $Ativo->setStatus($linha['ESTATUS']);
                $Ativo->setCodigoBarra($linha['CODIGOBARRA']);
                $Ativo->setDtRegistro($linha['DTREGISTRO']);
                $Ativo->setSituacao($linha['SITUACAO']);
                $lista[$c] = $Ativo;
                $c++;
            }
        }
        $this->Conexao->fecharConexao();
        return $lista;
    }
    
    public function relContarAtivosBaixa($idUnidade) {
        $quantidade = 0;
        $this->Conexao->abrirConexao();
        $resultado = $this->Conexao->getConexao()->query(
            "SELECT COUNT(ATIVO.ID) AS QUANTIDADE FROM ATIVO, UNIDADE, AMBIENTE " .
            "WHERE ATIVO.ESTATUS = 3 " .
            "AND UNIDADE.ID = " . $idUnidade . " " .
            "AND AMBIENTE.ID = ATIVO.IDAMBIENTE " .
            "AND UNIDADE.ID = AMBIENTE.IDUNIDADE;"
            );
        $numeroLinhas = mysqli_num_rows($resultado);
        if ($numeroLinhas > 0) {
            $linha = mysqli_fetch_assoc($resultado);
            $quantidade = $linha['QUANTIDADE'];
        }
        $this->Conexao->fecharConexao();
        return $quantidade;
    }
    
    public function relListarAtivosBaixa($idUnidade) {
        $lista = null;
        $this->Conexao->abrirConexao();
        $resultado = $this->Conexao->getConexao()->query(
            "SELECT ATIVO.*" .
            ", GRUPO.NOME AS NOMEGRUPO" .
            ", SUBGRUPO.IDGRUPO AS SUBGRUPOIDGRUPO" .
            ", SUBGRUPO.NOME AS NOMESUBGRUPO" .
            ", FUNCIONARIO.NOME AS NOMEFUNCIONARIO" .
            ", AMBIENTE.NOME AS NOMEAMBIENTE" .
            ", UNIDADE.NOME AS UNIDADENOME" .
            " FROM ATIVO, GRUPO, SUBGRUPO, FUNCIONARIO, AMBIENTE, UNIDADE" .
            " WHERE ATIVO.ESTATUS = 3 AND UNIDADE.ID = " . $idUnidade . " AND SUBGRUPO.IDGRUPO = GRUPO.ID AND ATIVO.IDSUBGRUPO = SUBGRUPO.ID AND ATIVO.IDFUNCIONARIO = FUNCIONARIO.ID AND ATIVO.IDAMBIENTE = AMBIENTE.ID AND AMBIENTE.IDUNIDADE = UNIDADE.ID" .
            " ORDER BY ATIVO.NOME DESC;");
        $numeroLinhas = mysqli_num_rows($resultado);
        if ($numeroLinhas > 0) {
            $c = 0;
            while ($linha = mysqli_fetch_assoc($resultado)) {
                $Ativo = new Ativo();
                $Ativo->setId($linha['ID']);
                $Subgrupo = new Subgrupo();
                $Subgrupo->setId($linha['IDSUBGRUPO']);
                $Grupo = new Grupo();
                $Grupo->setId($linha['SUBGRUPOIDGRUPO']);
                $Grupo->setNome($linha['NOMEGRUPO']);
                $Subgrupo->setGrupo($Grupo);
                $Subgrupo->setNome($linha['NOMESUBGRUPO']);
                $Ativo->setSubgrupo($Subgrupo);
                $Ambiente = new Ambiente();
                $Unidade = new Unidade();
                $Unidade->setNome($linha['UNIDADENOME']);
                $Ambiente->setUnidade($Unidade);
                $Ambiente->setId($linha['IDAMBIENTE']);
                $Ambiente->setNome($linha['NOMEAMBIENTE']);
                $Ativo->setAmbiente($Ambiente);
                $Funcionario = new Funcionario();
                $Funcionario->setId($linha['IDFUNCIONARIO']);
                $Funcionario->setNome($linha['NOMEFUNCIONARIO']);
                $Ativo->setFuncionario($Funcionario);
                $Ativo->setNome($linha['NOME']);
                $Ativo->setDescricao($linha['DESCRICAO']);
                $Ativo->setStatus($linha['ESTATUS']);
                $Ativo->setCodigoBarra($linha['CODIGOBARRA']);
                $Ativo->setDtRegistro($linha['DTREGISTRO']);
                $Ativo->setSituacao($linha['SITUACAO']);
                $lista[$c] = $Ativo;
                $c++;
            }
        }
        $this->Conexao->fecharConexao();
        return $lista;
    }
    
    public function relContarAtivosOutroAmbienteMesmaUnidade($idUnidade) {
        $quantidade = 0;
        $this->Conexao->abrirConexao();
        $resultado = $this->Conexao->getConexao()->query(
            "SELECT COUNT(ATIVO.ID) AS QUANTIDADE FROM ATIVO, UNIDADE, AMBIENTE AS AMBIENTE, AMBIENTE AS AMBD, MOVIMENTACAO " .
            "WHERE ATIVO.ESTATUS = 1 " .
            "AND UNIDADE.ID = " . $idUnidade . " " .
            "AND AMBIENTE.ID = ATIVO.IDAMBIENTE " .
            "AND UNIDADE.ID = AMBIENTE.IDUNIDADE " .
            "AND MOVIMENTACAO.IDATIVO = ATIVO.ID " .
            
            
            "AND MOVIMENTACAO.IDAMBIENTEDESTINO = AMBD.ID " .
            "AND AMBD.IDUNIDADE = " . $idUnidade .
            
            ";"
            );
        $numeroLinhas = mysqli_num_rows($resultado);
        if ($numeroLinhas > 0) {
            $linha = mysqli_fetch_assoc($resultado);
            $quantidade = $linha['QUANTIDADE'];
        }
        $this->Conexao->fecharConexao();
        return $quantidade;
    }
    
    public function relListarAtivosOutroAmbienteMesmaUnidade($idUnidade) {
        $lista = null;
        $nomeAmbienteDestino = null;
        $movDtRetorno = null;
        $this->Conexao->abrirConexao();
        $resultado = $this->Conexao->getConexao()->query(
            "SELECT ATIVO.*" .
            ", GRUPO.NOME AS NOMEGRUPO" .
            ", SUBGRUPO.IDGRUPO AS SUBGRUPOIDGRUPO" .
            ", SUBGRUPO.NOME AS NOMESUBGRUPO" .
            ", FUNCIONARIO.NOME AS NOMEFUNCIONARIO" .
            ", AMBIENTE.NOME AS NOMEAMBIENTE" .
            ", UNIDADE.NOME AS UNIDADENOME" .
            
            ", MOVIMENTACAO.DTRETORNO AS MOVIMENTACAODTRETORNO " .
            
            ", AMBD.NOME AS AMBIENTEDESTINONOME " .
            
            
            
            " FROM ATIVO, GRUPO, SUBGRUPO, FUNCIONARIO, AMBIENTE AS AMBIENTE, UNIDADE, AMBIENTE AS AMBD, MOVIMENTACAO" .
            " WHERE ATIVO.ESTATUS = 1 AND UNIDADE.ID = " . $idUnidade . " AND SUBGRUPO.IDGRUPO = GRUPO.ID AND ATIVO.IDSUBGRUPO = SUBGRUPO.ID AND ATIVO.IDFUNCIONARIO = FUNCIONARIO.ID AND ATIVO.IDAMBIENTE = AMBIENTE.ID AND AMBIENTE.IDUNIDADE = UNIDADE.ID" .
            
            " AND MOVIMENTACAO.IDATIVO = ATIVO.ID " .
            " AND MOVIMENTACAO.IDAMBIENTEDESTINO = AMBD.ID " .
            " AND AMBD.IDUNIDADE = " . $idUnidade .
            
            " ORDER BY ATIVO.NOME DESC;");
        $numeroLinhas = mysqli_num_rows($resultado);
        if ($numeroLinhas > 0) {
            $c = 0;
            while ($linha = mysqli_fetch_assoc($resultado)) {
                $Ativo = new Ativo();
                $Ativo->setId($linha['ID']);
                $Subgrupo = new Subgrupo();
                $Subgrupo->setId($linha['IDSUBGRUPO']);
                $Grupo = new Grupo();
                $Grupo->setId($linha['SUBGRUPOIDGRUPO']);
                $Grupo->setNome($linha['NOMEGRUPO']);
                $Subgrupo->setGrupo($Grupo);
                $Subgrupo->setNome($linha['NOMESUBGRUPO']);
                $Ativo->setSubgrupo($Subgrupo);
                $Ambiente = new Ambiente();
                $Unidade = new Unidade();
                $Unidade->setNome($linha['UNIDADENOME']);
                $Ambiente->setUnidade($Unidade);
                $Ambiente->setId($linha['IDAMBIENTE']);
                $Ambiente->setNome($linha['NOMEAMBIENTE']);
                $Ativo->setAmbiente($Ambiente);
                $Funcionario = new Funcionario();
                $Funcionario->setId($linha['IDFUNCIONARIO']);
                $Funcionario->setNome($linha['NOMEFUNCIONARIO']);
                $Ativo->setFuncionario($Funcionario);
                $Ativo->setNome($linha['NOME']);
                $Ativo->setDescricao($linha['DESCRICAO']);
                $Ativo->setStatus($linha['ESTATUS']);
                $Ativo->setCodigoBarra($linha['CODIGOBARRA']);
                $Ativo->setDtRegistro($linha['DTREGISTRO']);
                $Ativo->setSituacao($linha['SITUACAO']);
                $lista[$c] = $Ativo;
                
                $nomeAmbienteDestino[$c] = $linha['AMBIENTEDESTINONOME'];
                $movDtRetorno[$c] = $linha['MOVIMENTACAODTRETORNO'];
                
                $c++;
            }
        }
        $this->Conexao->fecharConexao();
        return array($lista, $nomeAmbienteDestino, $movDtRetorno);
    }
    
    public function relContarAtivosOutraUnidade($idUnidade) {
        $quantidade = 0;
        $this->Conexao->abrirConexao();
        $resultado = $this->Conexao->getConexao()->query(
            "SELECT COUNT(ATIVO.ID) AS QUANTIDADE FROM ATIVO, UNIDADE, AMBIENTE AS AMBIENTE, AMBIENTE AS AMBD, MOVIMENTACAO " .
            "WHERE ATIVO.ESTATUS = 1 " .
            "AND UNIDADE.ID = " . $idUnidade . " " .
            "AND AMBIENTE.ID = ATIVO.IDAMBIENTE " .
            "AND UNIDADE.ID = AMBIENTE.IDUNIDADE " .
            "AND MOVIMENTACAO.IDATIVO = ATIVO.ID " .
            
            
            "AND MOVIMENTACAO.IDAMBIENTEDESTINO = AMBD.ID " .
            "AND AMBD.IDUNIDADE != " . $idUnidade .
            
            ";"
            );
        $numeroLinhas = mysqli_num_rows($resultado);
        if ($numeroLinhas > 0) {
            $linha = mysqli_fetch_assoc($resultado);
            $quantidade = $linha['QUANTIDADE'];
        }
        $this->Conexao->fecharConexao();
        return $quantidade;
    }
    
    public function relListarAtivosOutraUnidade($idUnidade) {
        $lista = null;
        $nomeAmbienteDestino = null;
        $movDtRetorno = null;
        $nomeUnidadeDestino = null;
        $this->Conexao->abrirConexao();
        $resultado = $this->Conexao->getConexao()->query(
            "SELECT ATIVO.*" .
            ", GRUPO.NOME AS NOMEGRUPO" .
            ", SUBGRUPO.IDGRUPO AS SUBGRUPOIDGRUPO" .
            ", SUBGRUPO.NOME AS NOMESUBGRUPO" .
            ", FUNCIONARIO.NOME AS NOMEFUNCIONARIO" .
            ", AMBIENTE.NOME AS NOMEAMBIENTE" .
            ", UNIDADE.NOME AS UNIDADENOME" .
            
            ", UNIDADED.NOME AS UNIDADEDESTINONOME " .
            
            ", MOVIMENTACAO.DTRETORNO AS MOVIMENTACAODTRETORNO " .
            
            ", AMBD.NOME AS AMBIENTEDESTINONOME " .
            
            
            
            " FROM ATIVO, GRUPO, SUBGRUPO, FUNCIONARIO, AMBIENTE AS AMBIENTE, UNIDADE AS UNIDADE, UNIDADE AS UNIDADED, AMBIENTE AS AMBD, MOVIMENTACAO" .
            " WHERE ATIVO.ESTATUS = 1 AND UNIDADE.ID = " . $idUnidade . " AND SUBGRUPO.IDGRUPO = GRUPO.ID AND ATIVO.IDSUBGRUPO = SUBGRUPO.ID AND ATIVO.IDFUNCIONARIO = FUNCIONARIO.ID AND ATIVO.IDAMBIENTE = AMBIENTE.ID AND AMBIENTE.IDUNIDADE = UNIDADE.ID" .
            
            " AND MOVIMENTACAO.IDATIVO = ATIVO.ID " .
            " AND MOVIMENTACAO.IDAMBIENTEDESTINO = AMBD.ID " .
            " AND AMBD.IDUNIDADE != " . $idUnidade .
            
            " AND UNIDADED.ID = AMBD.IDUNIDADE " .
            
            " ORDER BY ATIVO.NOME DESC;");
        $numeroLinhas = mysqli_num_rows($resultado);
        if ($numeroLinhas > 0) {
            $c = 0;
            while ($linha = mysqli_fetch_assoc($resultado)) {
                $Ativo = new Ativo();
                $Ativo->setId($linha['ID']);
                $Subgrupo = new Subgrupo();
                $Subgrupo->setId($linha['IDSUBGRUPO']);
                $Grupo = new Grupo();
                $Grupo->setId($linha['SUBGRUPOIDGRUPO']);
                $Grupo->setNome($linha['NOMEGRUPO']);
                $Subgrupo->setGrupo($Grupo);
                $Subgrupo->setNome($linha['NOMESUBGRUPO']);
                $Ativo->setSubgrupo($Subgrupo);
                $Ambiente = new Ambiente();
                $Unidade = new Unidade();
                $Unidade->setNome($linha['UNIDADENOME']);
                $Ambiente->setUnidade($Unidade);
                $Ambiente->setId($linha['IDAMBIENTE']);
                $Ambiente->setNome($linha['NOMEAMBIENTE']);
                $Ativo->setAmbiente($Ambiente);
                $Funcionario = new Funcionario();
                $Funcionario->setId($linha['IDFUNCIONARIO']);
                $Funcionario->setNome($linha['NOMEFUNCIONARIO']);
                $Ativo->setFuncionario($Funcionario);
                $Ativo->setNome($linha['NOME']);
                $Ativo->setDescricao($linha['DESCRICAO']);
                $Ativo->setStatus($linha['ESTATUS']);
                $Ativo->setCodigoBarra($linha['CODIGOBARRA']);
                $Ativo->setDtRegistro($linha['DTREGISTRO']);
                $Ativo->setSituacao($linha['SITUACAO']);
                $lista[$c] = $Ativo;
                
                $nomeAmbienteDestino[$c] = $linha['AMBIENTEDESTINONOME'];
                $nomeUnidadeDestino[$c] = $linha['UNIDADEDESTINONOME'];
                $movDtRetorno[$c] = $linha['MOVIMENTACAODTRETORNO'];
                
                $c++;
            }
        }
        $this->Conexao->fecharConexao();
        return array($lista, $nomeAmbienteDestino, $nomeUnidadeDestino, $movDtRetorno);
    }
}