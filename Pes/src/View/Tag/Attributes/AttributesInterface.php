<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Pes\View\Tag\Attributes;

/**
 *
 * @author pes2704
 */
interface AttributesInterface {
    
    /**
     * Metoda vrací hodnoty a názvy atributů elementu jako asociativní pole.
     * @return array
     */  
    public function getAttributesArray();
    
    /**
     * Nastaví hodnoty atributů podle asociativního pole zadaného jako parametr. 
     * @param array $attributesArray
     */
    public function setAttributesArray();
    
    /**
     * Metoda vrací hodnoty a názvy atributů elementu jako string ve tvaru vhodném pro vypsání html elementu.
     * Formát: <br/> 
     * Pokud je hodnota atributu typu boolean je TRUE, do řetezce je přidán je název atributu, 
     * pokud hodnota atributu není boolean, do řetězce je přidán atribut s hodnotou ve formátu atribut="hodnota" (hodnota je vždy uzavřena do uvozovek)
     * pokud je hodnota vyhodnocena jako FALSE (nula, prázdný řetezec, FALSE), do řetezce není přidáno nic.
     * 
     * Příklad:<br/>
     * <code>$attributes->class = "qwertz", $atributes->name = "", attributes->required = TRUE, $attributes->hidden = FALSE</code><br/>
     * vznikne: class="qwertz" required
     * 
     * @return string
     */    
    public function getString();
    
    /**
     * Magická metoda, alias pro getString.
     */
    public function __toString() ;
    }
