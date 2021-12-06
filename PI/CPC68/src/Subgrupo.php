<?php
namespace src;
include_once 'Grupo.php';

class Subgrupo
{
    private $id;
    
    private $Grupo;

    private $nome;

    private $descricao;

    private $dtRegistro;

    private $situacao;
    
    public function __construct() {
        $this->Grupo = new Grupo();
    }
    
    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return \src\Grupo
     */
    public function getGrupo()
    {
        return $this->Grupo;
    }

    /**
     * @return mixed
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * @return mixed
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * @return mixed
     */
    public function getDtRegistro()
    {
        return $this->dtRegistro;
    }

    /**
     * @return mixed
     */
    public function getSituacao()
    {
        return $this->situacao;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param \src\Grupo $Grupo
     */
    public function setGrupo($Grupo)
    {
        $this->Grupo = $Grupo;
    }

    /**
     * @param mixed $nome
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    /**
     * @param mixed $descricao
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
    }

    /**
     * @param mixed $dtRegistro
     */
    public function setDtRegistro($dtRegistro)
    {
        $this->dtRegistro = $dtRegistro;
    }

    /**
     * @param mixed $situacao
     */
    public function setSituacao($situacao)
    {
        $this->situacao = $situacao;
    }
}