<?php

namespace core;

use src\Config;

class Principal {

    /* ===================================================================================================================================================================================================================== */
    /* =================================================================================================== MONTA OS PATHS ================================================================================================== */
    /* ===================================================================================================================================================================================================================== */

    /**
     * Retorna Path Base do Sistema
     * @return string
     */
    private static function getPathBase() {
        $base = (isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) == 'on') ? 'https://' : 'http://';
        $base .= $_SERVER['SERVER_NAME'];
        if ($_SERVER['SERVER_PORT'] != '80') {
            $base .= ':' . $_SERVER['SERVER_PORT'];
        }
        return $base;
    }

    private static function getPathRoot() {
        $path = dirname(__DIR__);
        return str_replace('\\', '/', $path);
    }

    /**
     * Retorna a URL Base
     * @return string
     */
    public static function getBaseUrl() {
        return self::getPathBase() . Config::BASE_DIR;
    }

    /**
     * Retorna o Path de Acesso aos Arquivos Java Script
     * @return string
     */
    public static function getPathJs() {
        return self::getPathBase()  . '/curso-video/src/js';
    }

    /**
     * Retorna o DIretório de Acesso aos Arquivos Upload
     * @return string
     */
    public static function getDiretorioUpload() {
        return self::getPathRoot()  . '/uploads';
    }

    /**
     * Retorna o Path de Acesso aos Arquivos de Upload
     * @return string
     */
    public static function getPathUpload() {
        return self::getPathBase()  . Config::BASE_DIR_UPLOAD;
    }

}
