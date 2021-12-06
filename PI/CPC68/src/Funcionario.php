<?php
namespace src;

include_once 'Cargo.php';
include_once 'Unidade.php';

class Funcionario
{

    private $id;

    private $Cargo;

    private $CargoSuperior;

    private $Unidade;

    private $idAtorCadastro;

    private $telefone;

    private $nome;

    private $email;

    private $turno;

    private $nivel;

    private $dtRegistro;

    private $login;

    private $senha;

    private $situacao;

    public function __construct()
    {
        $this->Cargo = new Cargo();
        $this->CargoSuperior = new Cargo();
        $this->Unidade = new Unidade();
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getCargo()
    {
        return $this->Cargo;
    }

    public function setCargo($Cargo)
    {
        $this->Cargo = $Cargo;
    }

    public function getCargoSuperior()
    {
        return $this->CargoSuperior;
    }

    public function setCargoSuperior($CargoSuperior)
    {
        $this->CargoSuperior = $CargoSuperior;
    }

    public function getUnidade()
    {
        return $this->Unidade;
    }

    public function setUnidade($Unidade)
    {
        $this->Unidade = $Unidade;
    }

    public function getIdAtorCadastro()
    {
        return $this->idAtorCadastro;
    }

    public function setIdAtorCadastro($idAtorCadastro)
    {
        $this->idAtorCadastro = $idAtorCadastro;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    public function getTelefone()
    {
        return $this->telefone;
    }

    public function setTelefone($telefone)
    {
        $this->telefone = $telefone;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getTurno()
    {
        return $this->turno;
    }

    public function setTurno($turno)
    {
        $this->turno = $turno;
    }

    public function getNivel()
    {
        return $this->nivel;
    }

    public function setNivel($nivel)
    {
        $this->nivel = $nivel;
    }

    public function getDtRegistro()
    {
        return $this->dtRegistro;
    }

    public function setDtRegistro($dtRegistro)
    {
        $this->dtRegistro = $dtRegistro;
    }

    public function getLogin()
    {
        return $this->login;
    }

    public function setLogin($login)
    {
        $this->login = $login;
    }

    public function getSenha()
    {
        return $this->senha;
    }

    public function setSenha($senha)
    {
        $this->senha = $senha;
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