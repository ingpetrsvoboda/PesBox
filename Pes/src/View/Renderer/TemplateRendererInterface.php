<?php

namespace Pes\View\Renderer;

use Pes\View\Template\TemplateInterface;
/**
 * TemplateRendererInterface je rozhraní rendereru pro template objekty
 * @author pes2704
 */
interface TemplateRendererInterface extends RendererInterface {
    /**
     * @return TemplateInterface Template object
     */
    public function getTemplate();
}
