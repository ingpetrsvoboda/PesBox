                            <section class="perex">
                                <div class="ui segment">
                                    <div class="ui two equal width column grid">
                                        <div class="sixteen wide mobile seven wide tablet five wide computer column middle aligned center aligned">
                                            <img class="ui image" <?= $this->attributes($pribehPerex['pribehyPerexImageAttributes']) ?> />
                                        </div>
                                        <div class="column">  
                                            <h3>
                                                <a <?= $this->attributes($pribehPerex['pribehyPerexTitleAttributes']) ?>> 
                                                    <?= $this->mono($pribehPerex['pribehyPerexTitleText'])?> 
                                                </a>
                                            </h3>
                                            <?= $this->p($this->mono($this->esc($pribehPerex['pribehyPerexText']))) ?>
                                            <p>
                                                <a class="ui secondary basic button" <?= $this->attributes($pribehPerex['pribehyPerexButtonAttributes'])?> > <?=$pribehPerex['pribehyPerexButtonText']?></a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </section>     

