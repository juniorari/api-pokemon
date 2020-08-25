<?php


namespace app\widgets;

/**
 * Classe conteiner para métodos estatísticos de utilidades variadas
 *
 * @author Ari Junio(r)
 *
 */
class Utils
{

    public function init()
    {
        //caso for usar uma data, já configura para Manaus
        date_default_timezone_set('America/Manaus');
    }

    /**
     * Make a string uppercase.
     *
     * @param string The string to convert to uppercase.
     * @return string The converted string.
     */
    public static function Maiuscula($str)
    {
        if (function_exists("mb_strtoupper")) {
            return mb_strtoupper($str, mb_detect_encoding($str));
        } else {
            return strtr(strtoupper($str), "àáâãäåæçèéêëìíîïðñòóôõö÷øùüúþÿý", "ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖ×ØÙÜÚÞßÝ");
        }
    }


    /**
     * Função para remover os acentos da string. Útil para criar nomes de arquivos
     * @param string    - A string que quer remor os acentos
     * @return string    - A string retornada sem os acentos
     * Para usar: echo RemoverAcentos("Não vai os espaços nem acentuação");
     */
    public static function RemoverAcentos($string)
    {
        return preg_replace('/[`^~\'"]/', null, iconv('UTF-8', 'ASCII//TRANSLIT', $string));
    }


    /***
     * Faz o corte de uma string, com o tamanho definido
     * @param $str
     * @param int $tam
     * @param string $strFinal
     * @return string
     */
    public static function strCorta($str, $tam = 15, $strFinal = '…')
    {
        if (strlen($str) <= 0) return '';
        $t = ($tam <= 0 ? 15 : $tam);
        if (strlen($str) <= $t) return $str;
        $midle = floor($t / 2);
        return trim(substr($str, 0, $midle)) . $strFinal . trim(substr($str, -($midle - strlen($strFinal))));
    }


}


