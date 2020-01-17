                    <h2>Příběhy reálných lidí pro inspiraci</h2>
                    <div class="ui grid">
                        <div class="fifteen wide mobile thirteen wide tablet eleven wide computer column">
                            <?= $this->insert('templates/main/pribehy_perexy/googleForm.php') ?>
                            <?= $this->repeat('templates/main/pribehy_perexy/perex.php', $perexy) ?>
                        </div>
                    </div>