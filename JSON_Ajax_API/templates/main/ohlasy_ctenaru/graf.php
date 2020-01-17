                                <h2><?= $this->filter('mono',$nadpis)?></h2>
                                <a <?= $this->attributes($odkazAttributes)?>>
                                    <img <?= $this->attributes($imgAttributes)?>>
                                    <?= $this->filter('e|mono|p',$odkazText) ?>
                                </a>

