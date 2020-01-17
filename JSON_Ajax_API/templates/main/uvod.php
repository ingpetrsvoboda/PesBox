                        <section class="uvod-slovo">
                            <?= $this->insert("templates/main/uvod/uvodniSlovo.php", $uvodniSlovo)?>
                        </section>
                        <section class="anotace">
                            <?= $this->insert("templates/main/uvod/anotace.php", $anotace)?> 
                        </section>
                        <section class="tem-okruhy"> 
                            <?= $this->insert("templates/main/uvod/tematickeOkruhy.php", $tematickeOkruhy)?>  
                        </section>
                        <section class="ukazka">
                            <?= $this->insert("templates/main/uvod/ukazka.php", $ukazka) ?>
                        </section>
                        <section class="ohlasy">
                            <?= $this->insert("templates/main/uvod/ohlasyCtenaru.php", $ohlasyCtenaruUvod) ?>
                        </section>
                        <?= $this->insert("templates/main/kontakt.php", $kontakt) ?>
                        