                    <div class="ui centered grid">
                       <div class="fourteen wide mobile twelve wide tablet ten wide computer column justified">
                            <div class="ui breadcrumb">
                                    <a class="section" href="index.php?main=pribehy"> <?= $pribehyStudentu['nazev'] ?></a>
                                    <i class="right angle icon divider"></i>
                                    <p class="active section"><?= $pribehyStudentu['DavidBrabec']['autor'] ?></p> 
                            </div> 
                            <article> 
                                <h2><?= $this->filter('e|mono', $pribehPerex['pribehyPerexTitleText']) ?></h2>
                                <?= $this->filter('e|mono|p', $pribehPerex['pribehyPerexText']) ?>                                    
                                <img <?= $this->attributes($pribehyStudentu['DavidBrabec']['imgPribehuAttributes']) ?> /> 
                                <?= $this->filter('e|mono|p', $pribehyStudentu['DavidBrabec']['castPribehu']) ?>
                                <img <?= $this->attributes($pribehyStudentu['DavidBrabec']['imgAutoraAttributes'])?> />
                                <?= $this->filter('e|mono|p', $pribehyStudentu['DavidBrabec']['cast2Pribehu']) ?>
                            </article> 
                            <div class="ui horizontal divider"><?= $pribehyStudentu['divider'] ?></div>
                            <?= $this->repeat('templates/main/pribehy/perex.php', $context['perexy']) ?>
                        </div>
                    </div>