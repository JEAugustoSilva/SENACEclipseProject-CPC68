<?php
namespace src;

include_once 'Conexao.php';
include_once 'Unidade.php';

class DatabaseRepositorio
{

    private $Conexao;

    public function __construct()
    {
        $this->Conexao = new Conexao();
    }
    
    public function existeBanco()
    {
        $retorno = FALSE;
        $this->Conexao->abrirConexao();
        $numeroLinhas = mysqli_num_rows($this->Conexao->getConexao()->query(
            "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = 'dbcpc68'"));
        if ($numeroLinhas > 0) {
            $retorno = TRUE;
        }
        $this->Conexao->fecharConexao();
        return $retorno;
    }
    
    public function existeAdmin() 
    {
        $retorno = FALSE;
        $this->Conexao->abrirConexao();
        $numeroLinhas = mysqli_num_rows($this->Conexao->getConexao()->query(
            "SELECT * FROM FUNCIONARIO WHERE NOME = 'Administrador';"));
        if ($numeroLinhas > 0) {
            $retorno = TRUE;
        }
        $this->Conexao->fecharConexao();
        return $retorno;
    }
    
    public function consultarUnidadeADM()
    {
        $id = "";
        $this->Conexao->abrirConexao();
        $query = "SELECT * FROM UNIDADE WHERE NOME = '_adm';";
        $numeroLinhas = mysqli_num_rows($this->Conexao->getConexao()->query($query));
        if ($numeroLinhas > 0) {
            $l = mysqli_fetch_assoc($this->Conexao->getConexao()->query($query));
            $id = $l['ID'];
        }
        $this->Conexao->fecharConexao();
        return $id;
    }
    
    public function cadastrarUnidadeADM()
    {
        $this->Conexao->abrirConexao();
        $this->Conexao->getConexao()->query(
            "INSERT INTO UNIDADE(NOME,SIGLA,ENDERECO,DTREGISTRO,SITUACAO) " .
            "VALUES('_adm','','',NOW(),1);");
        $this->Conexao->fecharConexao();
    }
    
    public function consultarCargoADM()
    {
        $id = "";
        $this->Conexao->abrirConexao();
        $query = "SELECT * FROM CARGO WHERE NOME = '_adm';";
        $numeroLinhas = mysqli_num_rows($this->Conexao->getConexao()->query($query));
        if ($numeroLinhas > 0) {
            $l = mysqli_fetch_assoc($this->Conexao->getConexao()->query($query));
            $id = $l['ID'];
        }
        $this->Conexao->fecharConexao();
        return $id;
    }
    
    public function cadastrarCargoADM()
    {
        $this->Conexao->abrirConexao();
        $this->Conexao->getConexao()->query(
            "INSERT INTO CARGO(NOME,DESCRICAO,DTREGISTRO,SITUACAO) " .
            "VALUES('_adm','',NOW(),1);");
        $this->Conexao->fecharConexao();
    }
    
    public function cadastrarFuncionarioADM() {
        $retorno = FALSE;
        $this->Conexao->abrirConexao();
        if ($this->Conexao->getConexao()->query(
            "INSERT INTO FUNCIONARIO(IDCARGO,IDCARGOSUPERIOR,IDUNIDADE,IDATORCADASTRO,NOME,EMAIL,TELEFONE,TURNO,NIVEL,DTREGISTRO,LOGIN,SENHA,SITUACAO) " .
            "VALUES(NULL,NULL,NULL,0,'Administrador','','','',1,NOW(),'admin',SHA('admin'),9);")) {
            $retorno = TRUE;
        } else {
            echo "Falha no cadastro do funcionário. (REPOSITÓRIO)<br />";
        }
        $this->Conexao->fecharConexao();
        return $retorno;
    }
    
}