                    <div class="ui centered grid">
                       <div class="fourteen wide mobile twelve wide tablet ten wide computer column justified">
                            <?= $this->insert('templates/main/pribeh_a_ostatni_perexy/pribehLiveBlock.php', $pribeh) ?>
                            <div class="ui horizontal divider">Přečtěte si také</div>
                            <?= $this->repeat('templates/main/pribehy_perexy/perex.php', $perexy) ?>
                        </div>
                    </div>