<?php

/*
 * Copyright (C) 2017 pes2704
 *
 * This is no software. This is quirky text and you may do anything with it, if you like doing
 * anything with quirky texts. This text is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

namespace Pes\Utils;

/**
 * Description of Folder
 *
 * @author pes2704
 */
class Directory {
    
    /**
     * Nahradí levá lomítka za pravá a zajistí, aby cesta končila koncovým pravým lomítkem
     * @param string $directoryPath
     * @return string
     */
    public static function normalizePath($directoryPath) {
        return $directoryPath = rtrim(str_replace('\\', '/', $directoryPath), '/').'/';
    }
    
    /**
     * Vytvoří neexistující složky a podsložky. Přijímá celou cestu a vytvoří všechny případně neexistující složky v řadě.
     * @param type $directoryPath
     */
    public static function createDirectory($directoryPath) {
        $directoryPath = rtrim(str_replace('\\', '/', $directoryPath), '/').'/';
        if (!is_dir($directoryPath)) {  //pokud není složka, vytvoří ji
            $dirPath = '';
            foreach (explode('/', rtrim($directoryPath, '/')) as $directory) {   // bez koncového / - snažil by se tvořit ještě jednou vytvořenou složku
                $dirPath .= $directory.'/';
                if (!is_dir($dirPath)) {   // mořná neexistuje až nškterý podřazený adresář
                    mkdir($dirPath);    
                }
            }
        }        
    }
    
}
