<?php
namespace src;

class Unidade
{

    private $id;

    private $nome;

    private $sigla;

    private $endereco;

    private $dtRegistro;

    private $situacao;

    public function __construct()
    {}

    /**
     *
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     *
     * @return mixed
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     *
     * @return mixed
     */
    public function getSigla()
    {
        return $this->sigla;
    }

    /**
     *
     * @return mixed
     */
    public function getEndereco()
    {
        return $this->endereco;
    }

    /**
     *
     * @return mixed
     */
    public function getDtRegistro()
    {
        return $this->dtRegistro;
    }

    /**
     *
     * @return mixed
     */
    public function getSituacao()
    {
        return $this->situacao;
    }

    /**
     *
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     *
     * @param mixed $nome
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    /**
     *
     * @param mixed $sigla
     */
    public function setSigla($sigla)
    {
        $this->sigla = $sigla;
    }

    /**
     *
     * @param mixed $endereco
     */
    public function setEndereco($endereco)
    {
        $this->endereco = $endereco;
    }

    /**
     *
     * @param mixed $dtRegistro
     */
    public function setDtRegistro($dtRegistro)
    {
        $this->dtRegistro = $dtRegistro;
    }

    /**
     *
     * @param mixed $situacao
     */
    public function setSituacao($situacao)
    {
        $this->situacao = $situacao;
    }
}