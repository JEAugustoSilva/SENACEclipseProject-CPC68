<?php
namespace src;

include_once 'src/Ativo.php';
include_once 'src/Funcionario.php';
include_once 'src/Ambiente.php';

class Movimentacao
{

    private $id;

    private $Ativo;

    private $Funcionario;

    private $AmbienteAtual;

    private $AmbienteOrigem;

    private $AmbienteDestino;

    private $tipo;

    private $descricao;

    private $status;

    private $dtEntrada;

    private $dtSaida;

    private $dtRetorno;

    private $dtRegistro;

    private $situacao;

    public function __construct()
    {
        $this->Ativo = new Ativo();
        $this->Funcionario = new Funcionario();
        $this->AmbienteOrigem = new Ambiente();
        $this->AmbienteAtual = new Ambiente();
        $this->AmbienteDestino = new Ambiente();
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getAtivo()
    {
        return $this->Ativo;
    }

    public function setAtivo($Ativo)
    {
        $this->Ativo = $Ativo;
    }

    public function getFuncionario()
    {
        return $this->Funcionario;
    }

    public function setFuncionario($Funcionario)
    {
        $this->Funcionario = $Funcionario;
    }

    public function getAmbienteAtual()
    {
        return $this->AmbienteAtual;
    }

    public function setAmbienteAtual($AmbienteAtual)
    {
        $this->AmbienteAtual = $AmbienteAtual;
    }

    public function getAmbienteOrigem()
    {
        return $this->AmbienteOrigem;
    }

    public function setAmbienteOrigem($AmbienteOrigem)
    {
        $this->AmbienteOrigem = $AmbienteOrigem;
    }

    public function getAmbienteDestino()
    {
        return $this->AmbienteDestino;
    }

    public function setAmbienteDestino($AmbienteDestino)
    {
        $this->AmbienteDestino = $AmbienteDestino;
    }

    public function getTipo()
    {
        return $this->tipo;
    }

    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
    }

    public function getDescricao()
    {
        return $this->descricao;
    }

    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function getDtEntrada()
    {
        return $this->dtEntrada;
    }

    public function setDtEntrada($dtEntrada)
    {
        $this->dtEntrada = $dtEntrada;
    }

    public function getDtSaida()
    {
        return $this->dtSaida;
    }

    public function setDtSaida($dtSaida)
    {
        $this->dtSaida = $dtSaida;
    }

    public function getDtRetorno()
    {
        return $this->dtRetorno;
    }

    public function setDtRetorno($dtRetorno)
    {
        $this->dtRetorno = $dtRetorno;
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