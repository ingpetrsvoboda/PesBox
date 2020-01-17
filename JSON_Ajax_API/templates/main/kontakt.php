                        <section class="kontakt">
                            <h2><?= $this->filter('mono',$nadpisSekce)?></h2>
                            <div class="ui centered grid">
                                <div class="fourteen wide mobile ten wide tablet six wide computer column center aligned">
                                    <?= $this->insert("templates/main/kontakt/tabulka_kontaktu.php", $dataSekce) ?>
                                    <span><?= $this->filter('mono', $tymGrafia)?></span>
                                </div>
                            </div>
                        </section>