<?php

namespace Pes\View\Renderer;

use Pes\View\Tag\TagInterface;
use Pes\View\Node\TextInterface;
use Pes\View\Node\TextViewInterface;

use Pes\View\Recorder\RecordLogger;

/**
 * Description of TagRenderer
 *
 * @author pes2704
 */
class TagRenderer  implements TagRendererInterface {
    
    const INDENT = '    ';
    
    /**
     * @var TagInterface 
     */
    private $tag;
        
    /**
     * @var RecordLogger 
     */
    private $variablesUsageLogger;

    public function __construct(TagInterface $tag) {
        $this->tag = $tag;
    }
    
    /**
     * Vrací tag nastavený pro renderování
     * @return TagInterface
     */
    public function getTag(): TagInterface {
        return $this->tag;
    }

    /**
     * Nastaví objekt pro logování informací o užití proměnných v šabloně. Pokud je tentojekt nastaven, všechny objekty typů Template
     * @param RecordLogger $variablesUsageLogger
     */
    public function setRecordLogger(RecordLogger $variablesUsageLogger) {
        $this->variablesUsageLogger = $variablesUsageLogger;
        return $this;
    }
    
    public function render() {       
        return $this->recursiveRender($this->tag);
    }
    
    public function __toString() {
        return $this->render();
    }    
    
    private function recursiveRender(TagInterface $tag) {
        $attributes = $tag->getAttributes();
        $attributesString = isset($attributes) ? ' '.$attributes->getString() : '';
        if ($tag->isPairTag()) {
            // tag je párový - všechny tagy jsou párové s výjimkou pouze povinně nepárových tagů
            // párový tag má počáteční a koncovou značku a může mít obsah - buď text (Tag\Text) nebo potmkovské tagy
            $pieces[] = "<{$tag->getName()}$attributesString>";

            foreach ($tag->getChildrens() as $child) {
                if ($child instanceof TextInterface) {
                    
                    // potomek je textový node, ten je vždy list stromu nodů
                    // vrací nastavený text (Tag\Text) nebo vytvoří text pomocí factory (Tag\TextFactory) 
                    // nebo vytvoří text renderováním Template objektu (Tag\TextTemplate)
                    $pieces[] = $child->getText();
                    // pokud je potomek Tag\TextViewInterface a mám nastaven logger užití proměnných v templatě, pokusím se provést logování
                    // logování proběhne jen pokud Template objekty měly zapnutý záznam o užití proměnných.
                    if (isset($this->variablesUsageLogger) AND $template instanceof RecordableTemplateInterface) {
                        $this->variablesUsageLogger->logTemplateDebugInfo($template);
                    }                        
                } else {
                    // potomek je tag (ne textový node) - rekurzivně volám renderování
                    $pieces[] = $this->recursiveRender($child);
                }
            }
            
            $pieces[] = "</{$tag->getName()}>"; 
        } else {
            // tag je povinně nepárový - nemůže mít obsah
            $pieces[] = "<{$tag->getName()}$attributesString />";            
        }
        return implode(\PHP_EOL, $pieces);
    }
}
