                    <div class="ui stackable two column divided grid">
                         <?= $this->repeat("templates/main/skoly_firmy/infoSkolyFirmy.php", $infoSkolyFirmy); ?>
                    </div>
                    <div class="ui centered grid">
                        <div class="fifteen wide mobile twelve wide tablet ten wide computer column center aligned">
                            <i class="comments outline circular icon"></i>
                            <?= $this->filter('e|mono|p', $kontakt) ?>
                        </div>
                    </div>