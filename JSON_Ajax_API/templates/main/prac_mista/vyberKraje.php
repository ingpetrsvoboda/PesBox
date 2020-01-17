                            <div class="mapa">
                                <?= $this->repeat('templates/main/prac_mista/vyberKraje/vyberKrajeMapa.php', $seznamKraju) ?>
                            </div>
                            <form method="GET" action="" class="seznam-kraju">
                                <?= $this->repeat('templates/main/prac_mista/vyberKraje/hiddenInput.php', $hiddenInputs) ?> 
                                <select <?= $this->attributes($selectAttributes)?>>
                                    <?= $this->repeat('templates/main/prac_mista/vyberKraje/vyberKrajeSelectOption.php', $seznamKraju) ?>
                                </select>
                                <input class="ui basic button" type="submit" value="Vyhledat"/>
                            </form>