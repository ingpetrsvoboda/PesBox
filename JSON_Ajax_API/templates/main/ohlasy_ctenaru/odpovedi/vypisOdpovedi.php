                                <?php /* @var $this Pes\View\Renderer\PhpTempllaRenderer */ ?>
                                <section class="otazka">
                                    <h3 <?= $this->attributes(['id'=>'kotva'.$idOtazky])?>><?= $this->filter('e|mono', $otazka) ?></h3>
                                    <?= $this->repeat('templates/main/ohlasy_ctenaru/odpovedi/vypisOdpovedi/progressOdpoved.php', $progressOdpovedi) ?>

                                    <ul class="ui list">
                                        <?= $this->repeat('templates/main/ohlasy_ctenaru/odpovedi/vypisOdpovedi/li.php', $topDeset, 'odpoved') ?>
                                    </ul>

                                    <a <?= $this->attributes(['class'=>'oznaceni'.$idOtazky.'-vice'])?>>Další odpovědi<i class="caret down icon"></i></a>
                                    <div <?= $this->attributes(['class'=>'oznaceni'.$idOtazky])?>>
                                        <ul class="ui list">
                                            <?= $this->repeat('templates/main/ohlasy_ctenaru/odpovedi/vypisOdpovedi/li.php', $dalsiOdpovedi, 'odpoved') ?>
                                        </ul>

                                        <a <?= $this->attributes(['class'=>'oznaceni'.$idOtazky.'-mene', 'href'=>'#'.'kotva'.$idOtazky])?>>
                                            Zobrazit méně
                                            <i class="caret up icon"></i>
                                        </a>
                                    </div>
                                </section>
        <script>
            
            
           $(document).ready(function(){
               $(".oznaceni<?=$idOtazky?>").hide();
               
               $(".oznaceni<?=$idOtazky?>-vice").click(function(){
                $(".oznaceni<?=$idOtazky?>").toggle();
               });
               
               $(".oznaceni<?=$idOtazky?>-mene").click(function(){
                $(".oznaceni<?=$idOtazky?>").hide();
               });
               
               }); 
               
            
        </script>