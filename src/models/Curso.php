<?php

namespace Src\Models;

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

}
