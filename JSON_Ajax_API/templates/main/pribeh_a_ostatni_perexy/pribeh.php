
                            <div class="ui breadcrumb">
                                    <a class="section" href="index.php?main=pribehy">Příběhy studentů</a>
                                    <i class="right angle icon divider"></i>
                                    <p class="active section"><?= $autor ?></p>
                            </div>
                            <article>
                                <?= $this->insert('templates/main/pribeh_a_ostatni_perexy/pribeh/pribehPerex.php', $pribehPerex) ?>
                                <?= $this->insert('templates/main/pribeh_a_ostatni_perexy/pribeh/pribehClanek.php', $pribehClanek) ?>
                            </article>