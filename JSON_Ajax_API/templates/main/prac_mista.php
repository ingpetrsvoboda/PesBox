                    <h2><?= $this->filter('mono',$nadpisSekce)?></h2>
                    <div class="ui centered grid">   
                        <div class="sixteen wide mobile ten wide tablet fifteen wide computer column">
                            <?=$this->insert('templates/main/prac_mista/vyberKraje.php', $context)?>
                        </div>
                        <div class="fourteen wide column">
                            <?=$this->insert('templates/main/prac_mista/nabidka.php', $nabidkaPraceVKraji, 'templates/main/prac_mista/vyberteKraj.php');?>
                        </div>
                    </div>