<?php
namespace src;

include_once 'Subgrupo.php';
include_once 'Ambiente.php';
include_once 'Funcionario.php';

class Ativo
{

    private $id;

    private $Subgrupo;

    private $Ambiente;

    private $Funcionario;

    private $nome;

    private $descricao;

    private $codigoBarra;

    private $status;

    private $dtRegistro;

    private $situacao;

    public function __construct()
    {
        $this->Subgrupo = new Subgrupo();
        $this->Ambiente = new Ambiente();
        $this->Funcionario = new Funcionario();
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getSubgrupo()
    {
        return $this->Subgrupo;
    }

    public function setSubgrupo($Subgrupo)
    {
        $this->Subgrupo = $Subgrupo;
    }

    public function getAmbiente()
    {
        return $this->Ambiente;
    }

    public function setAmbiente($Ambiente)
    {
        $this->Ambiente = $Ambiente;
    }

    public function getFuncionario()
    {
        return $this->Funcionario;
    }

    public function setFuncionario($Funcionario)
    {
        $this->Funcionario = $Funcionario;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    public function getDescricao()
    {
        return $this->descricao;
    }

    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
    }

    public function getCodigoBarra()
    {
        return $this->codigoBarra;
    }

    public function setCodigoBarra($codigoBarra)
    {
        $this->codigoBarra = $codigoBarra;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function getDtRegistro()
    {
        return $this->dtRegistro;
    }

    public function setDtRegistro($dtRegistro)
    {
        $this->dtRegistro = $dtRegistro;
    }

    public function getSituacao()
    {
        return $this->situacao;
    }

    public function setSituacao($situacao)
    {
        $this->situacao = $situacao;
    }
}