<?php

namespace Pes\Tag;

/**
 * Description of Projektor2_View_HTML_ElementInterface
 *
 * @author pes2704
 */
interface TagInterface {
    public function addChild(TagAbstract $element);
    public function addHtmlPart($html);
}

