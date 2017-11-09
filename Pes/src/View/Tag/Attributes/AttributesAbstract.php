<?php

namespace Pes\View\Tag\Attributes;

/**
 * Description of AttributesAbstract
 *
 * @author pes2704
 */
abstract class AttributesAbstract implements AttributesInterface, \IteratorAggregate, \Countable {

    public function __construct(array $attributes=[]) {
        $this->setAttributesArray($attributes);
    }
    
    /**
     * Getter, vrací jen hodnoty existujících atributů.
     * @param type $name
     * @return type
     */
    public function __get($name) {
        if ($this->getIterator()->offsetExists($name)) {
            return $this->$name;
        } else {
            trigger_error("Attribut $name v objektu ". get_called_class()." nemá definovanou hodnotu.", E_USER_NOTICE);
        }
    }
    
    /**
     * Setter, nastavuje jen hodnoty existujících atributů, nepřidává další atributy elementu. 
     * V případě, že $name neodpovídá existujícímu atributu elementu metoda jen tiše skončí.
     * @param type $name
     * @param type $value
     */
    public function __set($name, $value) {
        $v = get_object_vars($this);
        if ($this->getIterator()->offsetExists($name)) {
            $this->$name = $value;
        } else {
            trigger_error("Attribut $name v objektu ". get_called_class()." neexituje.", E_USER_NOTICE);
        }
    }
    
    /**
     * Metoda vrací hodnoty a názvy atributů elementu jako asociativní pole.
     * @return array
     */    
    public function getAttributesArray() {
        return iterator_to_array($this->getIterator(), TRUE);
    }
    
    /**
     * Nastaví hodnoty atributů podle asociativního pole zadaného jako parametr. Prvky pole s indexem jemuž neodpovídá vlastnost atributu ignoruje.
     * @param array $attributesArray
     */
    public function setAttributesArray($attributesArray=array()) {
        $v = get_object_vars($this);
        foreach (get_object_vars($this) as $key => $name) {
            if (isset($attributesArray[$key])) {
                $this->$key = $attributesArray[$key];
            }
        }
    }

    /**
     * Metoda vrací hodnoty a názvy atributů elementu jako string ve tvaru vhodném pro vypsání html elementu.
     * Formát: Řetězec je složen z výrazů atribut="hodnota" nebo atribut oddělených mezerou. 
     * Pokud je hodnota atributu typu boolean je TRUE, do řetezce je přidán je název atributu, 
     * pokud hodnota atrubitu není boolean, do žetězce je přína dvojice atribut/hodnota ve formátu atribut="hodnota" (hodnota je vždy uzavřena do uvozovek)
     * pokud je hodnota vyhodnocena jako FALSE (nula, prázdný řetezec, FALSE), do řetezce není přidáno nic.
     * 
     * Příklad:
     * $attributes->class = "qwertz", $atributes->name = "", attributes->required = TRUE, $attributes->hidden = FALSE
     * vznikne: class="qwertz" required
     * 
     * @return string
     */    
    public function getString() {
        foreach (iterator_to_array($this->getIterator(), TRUE) as $key => $value) {
            if ($value) {
                if(is_bool($value)) {
                    $attr[] = $key;
                } else {
                    $attr[] = $key.'="'.trim($value).'"';
                }
            }
        }
        return isset($attr) ? implode(' ', $attr) : '';
    }
    
    public function __toString() {
        return $this->getString();
    }
    
    /**
     * Metoda vrací iterátor obsahující atributy elementu
     * @return \ArrayIterator
     */
    public function getIterator() {
        $defined = array();
        foreach (get_object_vars($this) as $key=>$val) {
            if ($val) {
                $defined[$key] = $val;
            }
        }
        return new \ArrayIterator($defined);  // vrací properties, které mají hodnotu
    }
    
    public function count(): int {
        return $this->getIterator()->count();
    }
}

