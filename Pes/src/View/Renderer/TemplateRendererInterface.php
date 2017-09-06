<?php

namespace Pes\View\Renderer;

/**
 * Framework_View_TemplateViewInterface je rozhraní rendereru pro template objekty
 * @author pes2704
 */
interface TemplateRendererInterface extends RendererInterface {
    public function loadTemplate($templateFileName);
}
