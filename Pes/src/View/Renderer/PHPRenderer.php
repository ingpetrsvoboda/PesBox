<?php

namespace Pes\View\Renderer;

/**
 * Description of PhpTemplate
 *
 * @author pes2704
 */
class PHPRenderer implements TemplateRendererInterface {

    /**
     * @var string 
     */
    protected $template;

    public function loadTemplate($templateFileName) {
        $this->template = $templateFileName;
    }

    /**
     * Render - vrací string
     * @param type $template název souboru s template (včetně přípony)
     * @param array $data asociativní pole dat - přidá se ke kontextu, ale pouze pro tento jeden render, položky kontextu se stejným indexem jsou nahrazeny těmito novými
     * @return string 
     * @throws \RuntimeException
     */
    public function render(array $data = []) {
        if (!is_file($this->template)) {
            throw new \RuntimeException("Nenalezen template soubor ".$this->template);
        }
        return $this->protectedIncludeScope($this->template, $data);
    }
    
    /**
     * @param string $template cesta k souboru s template
     * @param array $data asociativní pole
     */
    private function protectedIncludeScope ($template, array $data) {
        extract($data);
        
        // Ošeření výjimek a chyb vzniklých v template tak, abych nezahodil nějaký obsah, který byl zapsán do výstupního bufferu pčed vznikem výjimky
        //podla Plates - aktualizovaný příklad z http://php.net/manual/en/function.ob-get-level.php
        try {
            $level = ob_get_level();
            ob_start();
            include $template;
            $result = ob_get_clean();
        } catch (Throwable $e) {
            while (ob_get_level() > $level) {
                ob_end_clean();   
            }
            throw $e;
        } catch (Exception $e) {
            while (ob_get_level() > $level) {
                ob_end_clean();
            }
            throw $e;
        }                
        
//        $vars = get_defined_vars();
//        var_dump($GLOBALS);
//        echo '<pre>';
//        echo htmlspecialchars($a);
//        echo '</pre>';
        return $result;        
        
    }
}
