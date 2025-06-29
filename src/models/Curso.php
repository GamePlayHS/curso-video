<?php

namespace src\models;

use core\Model;

class Curso extends Model {

    /**
     * Código
     * @var int
     */
    private $codigo;
    /**
     * Título
     * @var string
     */
    private $titulo;
    /**
     * Descrição
     * @var string
     */
    private $descricao;
    /**
     * Imagem
     * @var string
     */
    private $imagem;
    /**
     * Nome Imagem
     * @var string
     */
    private $nomeImagem;
    /**
     * Tipo Imagem
     * @var string
     */
    private $tipoImagem;

    /**
     * Retorna o Código
     * @return int
     */
    public function getCodigo() {
        return $this->codigo;
    }

    /**
     * Define o Código
     * @param int $codigo
     */
    public function setCodigo($codigo) {
        $this->codigo = $codigo;
    }

    /**
     * Retorna o Título
     * @return string
     */
    public function getTitulo() {
        return $this->titulo;
    }

    /**
     * Define o Título
     * @param string $titulo
     */
    public function setTitulo($titulo) {
        $this->titulo = $titulo;
    }

    /**
     * Retorna a Descrição
     * @return string
     */
    public function getDescricao() {
        return $this->descricao;
    }

    /**
     * Define a Descrição
     * @param string $descricao
     */
    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    /**
     * Retorna a Imagem
     * @return string
     */
    public function getImagem() {
        return $this->imagem;
    }

    /**
     * Define a Imagem
     * @param string $imagem
     */
    public function setImagem($imagem) {
        $this->imagem = $imagem;
    }

    /**
     * Retorna o Nome da Imagem
     * @return string
     */
    public function getNomeImagem() {
        return $this->nomeImagem;
    }

    /**
     * Define o Nome da Imagem
     * @param string $nomeImagem
     */
    public function setNomeImagem($nomeImagem) {
        $this->nomeImagem = $nomeImagem;
    }

    /**
     * Retorna o Tipo Imagem
     * @return string
     */ 
    public function getTipoImagem() {
        return $this->tipoImagem;
    }

    /**
     * Define o Tipo Imagem
     * @param string $tipoImagem
     */ 
    public function setTipoImagem($tipoImagem) {
        $this->tipoImagem = $tipoImagem;
    }

}
