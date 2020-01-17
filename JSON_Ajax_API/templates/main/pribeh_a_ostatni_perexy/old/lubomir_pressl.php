                    <div class="ui centered  grid">
                        <div class="fifteen wide mobile twelve wide tablet ten wide computer center aligned column mg-t30">
                            <div class="ui grid">
                                <div class="ui breadcrumb">
                                    <a class="section" href="index.php?main=pribehy">Příběhy studentů</a>
                                    <i class="right angle icon divider"></i>
                                    <div class="active section">Lubomír Pressl</div>
                                </div>
                            </div>
                            <h2 class="sedy-nadpis"><?= $this->filter('e|mono', $pribehPerex['pribehyPerexTitleText']) ?></h2>
                            <hr class="cara-nadpisS">
                        </div>
                        <div class="fifteen wide mobile twelve wide tablet ten wide computer column">
                            <div class="clanek">
                                <p class="zvyraz-text">
                                    <?= $this->filter('e|mono', $pribehPerex['pribehyPerexText']) ?>                                    
                                </p>
                                <div class="ui centered grid">
                                    <div class="fifteen wide column center aligned">
                                        <div class="ui image"><img src="public/images/drevorubec.jpg" alt="obrazek"></div>
                                        <p class="mg-b40"></p>
                                    </div>
                                </div>
                                    <?= $this->filter('e|mono', '
                                        Školu jsem dokončil s vyznamenáním a měl jsem přejít do Křimic na nástavbu na mechanizátora, ale to je práce s lidmi a to jsem nechtěl, vyzkoušel jsem si to na vojně. Šel jsem proto jako těžař s pilou do lesa nejdřív jako zaměstnanec Státních lesů. Po revoluci jsem se stal živnostníkem pro práci v lese. Znamená to, že si mne firmy najímají na konkrétní lesnické práce - kácení stromů, svážení dřeva, stavba lesních školek, prořezávání cest, sázení stromků... Baví mne práce v úkolu. Nechci se honit za kariérou.
                                    ') ?>
                                <div class="ui left floated small image"><img  src="public/images/lubomir-pressl1.jpg" alt="obrazek"></div>
                                    <?= $this->filter('e|mono|p', '
                                        Líbí se mi na tom ta SVOBODA. Dělám podle své potřeby, nemám pevnou pracovní dobu, jsem na čerstvém vzduchu a mám klid od lidí, nemusím se s nikým dohadovat. Zadají mi práci a já ji udělám. Jsem odpovědný sám za sebe. Je zajímavé, že i když pracuji v zimě i v plískanicích, nemarodím. Ale kdykoli přijdu mezi lidi, něco chytnu. Dělám to 29 let a neměnil bych. Mám stále skvělou kondici a čistou hlavu.
                                        Žiju na vesnici v Pošumaví, mám tak čas i na svého velkého koníčka - koně a rekreační ježdění. Hodně čtu, hlavně historické romány a publikace o Šumavě. Pořád je co objevovat.
                                    ') ?>
                                <p class="mg-b50">Pro absolventy mám jediné doporučení - nebojte se fyzické práce, je jí stále dost a není za co se stydět!</p>
                            </div>
                            <div class="ui horizontal divider">Přečtěte si také</div>
                            <p class="mg-b50"></p>
                                <?= $this->repeat('templates/main/pribehy/perex.php', $context['perexy']) ?>
                            <p class="mg-b50"></p>
                        </div>
                    </div>