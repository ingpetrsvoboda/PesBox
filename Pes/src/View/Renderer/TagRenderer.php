<?php

namespace Pes\View\Renderer;

use Pes\View\Tag\TagInterface;

use Pes\View\Recorder\RecorderProviderInterface;
use Pes\View\Node\TextViewInterface;

/**
 * Description of TagRenderer
 *
 * @author pes2704
 */
class TagRenderer  implements TagRendererInterface, RecordableRendererInterface {
    
    use RecordableRendererTrait;    
        
    /**
     * @var TagInterface 
     */
    private $tag;

    /**
     * 
     * @param TagInterface $tag
     * @param RecordLoggerInterface $recorderProvider <p>Nastaví objekt pro logování informací o užití 
     *      proměnných v šabloně. Pokud je nastaven, všechny renderery typu RecordableRendererInterface
     *      použité jako renderery v nodech typu TextView požádají tento RocordLogger o rekorder a zaznamenají užití dat při renderování šablon.</p>
     */
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
    
    public function render() {       
        return $this->recursiveRender($this->tag);
    }
    
    public function __toString() {
        return $this->render();
    }    
    
    private function recursiveRender(TagInterface $tag) {
        $attributes = $tag->getAttributes()->getString();
        $attributesString = $attributes ? ' '.$attributes : '';
        
        if ($tag->isPairTag()) {
            // tag je párový - všechny tagy ve frameworku jsou párové s výjimkou pouze povinně nepárových tagů (dobrovolně párové tagu jsou implementovány jako párové
            // párový tag má počáteční a koncovou značku a může mít obsah - buď text (Tag\Text) nebo potmkovské tagy
            $pieces[] = "<{$tag->getName()}$attributesString>";

            foreach ($tag->getChildrens() as $child) {
                if ($child instanceof TagInterface) {
                    // potomek je tag (ne textový node) - rekurzivně volám renderování
                    $pieces[] = $this->recursiveRender($child);                    
                } else {
                    // pokud je potomek Tag\TextViewInterface a mám nastaven recorder provider, nastavím template rendereru recorder
                    if (isset($this->recorderProvider) AND $child instanceof TextViewInterface) {
                        $textRenderer = $child->getView()->getRenderer();
                        if ($textRenderer instanceof RecordableRendererInterface ) {
                            $textRenderer->setRecorderProvider($this->recorderProvider);
                        }
                    }
                    // potomek je textový node, ten je vždy list stromu nodů
                    // getText() vrací text
                    $pieces[] = $child->getText();
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
