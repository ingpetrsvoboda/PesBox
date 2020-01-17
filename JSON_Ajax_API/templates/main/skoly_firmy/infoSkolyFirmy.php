                        <div class="column justified">
                            <h2><?= $this->filter('mono',$nadpis) ?></h2>
                            <h3><?= $this->filter('e|mono', $podnadpis) ?></h3>
                            <?= $this->filter('e|mono|p', $text) ?>
                        </div>
