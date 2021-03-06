<?php
namespace src;

include_once 'src/Unidade.php';

class Ambiente
{

    private $id;

    private $Unidade;

    private $nome;

    private $descricao;

    private $codigoBarra;

    private $dtRegistro;

    private $situacao;

    function __construct()
    {
        $this->Unidade = new Unidade();
    }
    
    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return \src\Unidade
     */
    public function getUnidade()
    {
        return $this->Unidade;
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
    public function getCodigoBarra()
    {
        return $this->codigoBarra;
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
     * @param \src\Unidade $Unidade
     */
    public function setUnidade($Unidade)
    {
        $this->Unidade = $Unidade;
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
     * @param mixed $codigoBarra
     */
    public function setCodigoBarra($codigoBarra)
    {
        $this->codigoBarra = $codigoBarra;
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