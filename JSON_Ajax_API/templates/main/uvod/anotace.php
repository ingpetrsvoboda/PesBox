                            <h2><?= $this->filter('mono',$nazevSekce)?></h2>
                            <div class="ui two column centered grid">
                                <div class="fourteen wide mobile nine wide tablet eight wide computer column justified">
                                    <?= $this->insert("templates/main/uvod/anotace/text.php", $dataSekce)?> 
                                </div>
                                <div class="sixteen wide mobile five wide tablet five wide computer column center aligned">
                                    <?= $this->repeat("templates/main/uvod/anotace/obrazek_popisek.php", $dataSekce['obrazky'])?> 
                                </div>
                            </div>