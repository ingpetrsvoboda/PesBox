<?php

/*
 * Copyright (C) 2017 pes2704
 *
 * This is no software. This is quirky text and you may do anything with it, if you like doing
 * anything with quirky texts. This text is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

namespace Pes\View\Template;

use Pes\View\Recorder\VariablesUsageRecorderInterface;

/**
 *
 * @author pes2704
 */
interface TemplatePhpInterface {
    public function getTemplateFilename();
    
    /**
     * Vykoná php kód v souboru zadaném jako šablona v konstruktoru template objektu s použitím předaných dat a vzniklý výstup vrací jako string. 
     * <p>Kód vykoná s použitím output bufferu. Spustí output buffer, ze zadaných dat vytvoří lokální proměnné metody, vykoná kód v souboru 
     * a v případných vložených souborech, odebere vzniklý výstup z output bufferu a ten odešle jako návratovou hodnotu - string. Kód se vykonává uvnitř metody 
     * a všechny vzniklé proměnné jsou tak lokální. Stejně pojmenované proměnné použité v různých šablonách se tedy neovlivňují.</p>
     * <p>Pokud je nastaven parametr recorder pro záznam informací o užití dat v template, zaznamenává informace o proměnných předaných jako data, 
     * nedefinovaných proměnných použitých v šabloně a o proměnných předaných, ale v šabloně nepoužitých.</p>
     * 
     * @param array $data Asociativní pole.
     * @param VariablesUsageRecorderInterface $recorder Rekorder pro záznam užití proměnných v šabloně.
     * @return string Výstup z output bufferu.
     */    
    public function render(array $data, VariablesUsageRecorderInterface $recorder = NULL);
    
    public function insert($templateFilename, $data=[]);
    public function repeat($data, $templateFilename);   // $data jsou povinný parametr - tak je první
    // trait:
    public function filter($filters, $text);
    public function e($text);
    public function esc($text);
    public function mono($text);
    public function p($text);
    public function nl2br($text);
    public function attributes(array $array);
}
