                            <h2><?= $this->filter('mono',$nadpisSekce)?></h2>
                            <div class="ui two column stackable centered grid left aligned">
                                <?= $this->repeat("templates/main/uvod/ohlasyCtenaru/rozdeleni_sloupcu.php", $dataSekce)?>
                            </div>