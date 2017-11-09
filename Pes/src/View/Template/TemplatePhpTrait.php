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

use Pes\View\ViewFactory;
use Pes\View\Recorder\VariablesUsageRecorder;

/**
 * PhpTemplateTrait obsahuje metody, tzv. filtry, které lze volat v html/php šablonách uvením php kódu $this->metoda(), jsou určeny 
 * pro tvůrce šablony a slouží jako pomocné metody pro generování textu z šablony. Obvykle se takovým metodám v template systémech
 * říká filtry.
 *  
 * Zde se využívá skutečnosti, že v okamžiku renderování šablony se šablona provádí jako php kód příkazem include 
 * uvnitř metody PhpTemplate->protectedIncludeScope() a v tu chvíli jsou z kódu šablony viditelné a spustitelné 
 * všechny metody objektu PhpTemplate.
 * 
 * @author pes2704
 */
trait TemplatePhpTrait {
        
    /**
     * Metoda použije postupně zleva jednotlivé filtry uvedené jako posloupnost názvů filtrů oddělených znakem FILTER_DELIMITER. 
     * 
     * Příklad:
     * Pro FILTER_DELIMITER = '|' volání $this->(e|mono|p, 'Text, který bude filtrován.') způsobí postupné volání filtru (metody) 
     * e(), mono(), p(). Ekvivalentně zápisu:
     * <pre>
     * $this->p($this->mono($this->e('Text, který bude filtrován.')));
     * </pre>
     * 
     * @param type $filters
     * @param type $text
     * @return type
     */
    public function filter($filters, $text) {
        $names = explode(self::FILTER_DELIMITER, $filters);
        foreach ($names as $name) {
            if (method_exists($this, $name)) {
                $text = $this->$name($text);
            }
        }
        return $text;
    }

    /**
     * Alias k metodě esc().
     * 
     * @param type $text
     * @return type
     */
    public function e($text) {
        return $this->esc($text);            
    }

    /**
     * Metodu použijte na ošetření textů, které obsahují text zadaný uživatelem (např. ve formuláři). Jde o základní ochranu proti XSS útokům.
     * Metoda provede tzv escapování. Všechny znaky, které mohou v HTML mít význam, tzv. rezervované znaky HTML, převede na HTML entity. 
     * Např. znak < na &lt; apod.
     * Metoda nestačí na ošetření textů vkládaných kamkoli jinam než jen do textového obsahu tagu určeného k zobrazení. 
     * Nikdy nevkládejte uživatelem zadaný text do obsahu tagu <script>, do html komentáře <!-- -->, do názvu atributu, do jména tagu, do css. 
     * Tato místa nelze nikdy dokonale ošetřit.
     * 
     * Tato metoda escapuje i html entity, které byly v opravovaném textu, např. pokud text obsahuje "mluví o&nbsp;všem" vznikne "mluví o&amp;nbsp;všem". 
     * pozor tedy také na pořadí filtrovacích metod: $this->filter('e|mono', 'v neděli'); je v pořádku, zatímco $this->filter('mono|e', 'v neděli'); 
     * oescapuje i &nbsp; vytvořené filtrem "mono".
     * 
     * @param type $text
     * @return type
     */
    public function esc($text) {
        return htmlspecialchars($text);            
    }
    
    /**
     * Jednoznakové předložky a spojky pro český text. Metoda vloží mezi jednoznakové předložky nebo spojky a následující slovo nedělitelnou mezeru.
     * Jednoznakové předložky a spojky jsou: k, s, v, z, o, u, i, a.
     * 
     * @param type $text
     * @return type
     */
    public function mono($text) {
        return preg_replace('|(\s[ksvzouiaKSVZOUIA])\s|', '$1&nbsp;', trim($text));
    }
    
    /**
     * Převede text s dvakrát odřádkovanými odstavci na html paragrafy (<p></p>)
     * Vstupní text obalí na začátku a na konci otevíracím tagem <p> a koncovým tagem </p>, 
     * výskyty dvou odřádkovýní uvnitř textu chápe jako konec odstavce a z každého takto odděleného úseku textu vytvoří paragraf.
     * Jednoho odřádkování v textu si nijak nevšímá, váš vstupní text můžete jedním odřádkováním zalamovat libovolně, např. proto, aby byl vidět ve vašem editoru. 
     * Chcete-li skutečně vytvořit odstavec, použijte dvojí odřádkování.
     * 
     * Metoda nijak nemění jakékoli html značky (tagy) ani žádné viditelné znaky v textu, naopak mění odřádkování (CR, LF alias \r, \n) a whitespaces (mezery, tabelátory ad.).
     * @param type $text
     * @return string
     */
    public function p($text) {
        // kopie z https://core.trac.wordpress.org/browser/trunk/src/wp-includes/formatting.php
        // 
        if ( trim($text) === '' )
        return '';

        // Just to make things a little easier, pad the end.
//        $text = $text . "\n"; 
        // Standardizuje odřádkování na \n
        $text = str_replace(array("\r\n", "\r"), "\n", $text);
        // Odstraní více než dvě odřádkování za sebou
        $text = preg_replace("/\n\n+/", "\n\n", $text);
        // Rozdělí na kousky, separátor jsou dvě odřádkování (mezi může být libovolný počet whitespaces)
        $chunks = preg_split('/\n\s*\n/', $text, -1, PREG_SPLIT_NO_EMPTY);  //PREG_SPLIT_NO_EMPTY - preg_split vrací jen neprázné kousky

        // Složí text z kousků obalených počátečním a koncovým <p>
        $text = '';
        foreach ( $chunks as $chunk ) {
            $text .= '<p>' . trim($chunk) . "</p>\n";  // původně bylo $text .= '<p>' . trim($chunk, "\n") . "</p>\n";
        }
        // Under certain strange conditions it could create a P of entirely whitespace.
        $text = preg_replace('|<p>\s*</p>|', '', $text);
        return $text;
    }
    
    /**
     * Převede odřádkování v textu na značku (tag) <br />. Převádí každé odřádkování, vícenásobné odřádkování způsobí vícenásobné vložení značky.
     * 
     * @param type $text
     * @return type
     */
    public function nl2br($text) {
        return str_replace(array("\r\n", "\r", "\n"), "<br />", $text);
    }
    
    /**
     * Metoda generuje obsah.
     * Pro zadaný typ a hodnotu atributu generuje 
     * @param string $type
     * @param mixed $value
     * @return type
     */
    public function attribute($type, $value) {
        if (isset($value) AND is_bool($value)) {
            $attr = ' '.$type;
        } else {
            $attr = isset($value) ? ' '.$type.'="'.$value.'"' : '';
        }
        return $attr;
    }    
}
