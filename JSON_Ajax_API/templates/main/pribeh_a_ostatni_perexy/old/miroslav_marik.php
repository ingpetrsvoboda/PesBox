                    <div class="ui centered grid">
                        <div class="fourteen wide mobile twelve wide tablet ten wide computer column justified">
                            <div class="ui breadcrumb">
                                <a class="section" href="index.php?main=pribehy">Příběhy studentů</a>
                                <i class="right angle icon divider"></i>
                                <p class="active section">Miroslav Mařík</p> 
                            </div>
                            <article>
                                <h2><?= $this->filter('e|mono', $pribehPerex['pribehyPerexTitleText']) ?></h2>
                                <?= $this->filter('e|mono|p', $pribehPerex['pribehyPerexText']) ?>
                                <img class="ui image" src="public/images/hajny.jpg" alt="obrazek" />
                                <?= $this->filter('e|mono|p', '
                                    V dětství jsem chtěl být hajný nebo archeolog. Zjistil jsem ale, že moje představy o práci hajného se dost lišily od reality - je to víc o pěstování a těžbě dřeva než o ochraně lesa. Archeologii otvírali jednou za pár let, a tak mi táta technik poradil, že když máme jadernou elektrárnu za humny, perspektivní bude jít studovat obor energetika na VUT v Brně, který byl založen ve spolupráci s ČEZ, aby se podařilo vytipovat a připravit lidi schopné pracovat jako operátoři jaderné elektrárny. Toto povolání klade velmi vysoké nároky na psychickou odolnost, inteligenci a další vlastnosti, takže z 10 uchazečů vyhoví u přijímacích testů maximálně jeden. Zaujalo mne to.
                                    
                                    Po ukončení školy jsem další dva roky absolvoval další specializované programy završené státními zkouškami. Poté jsem cca 10 let pracoval postupně jako operátor sekundárního okruhu, operátor primárního okruhu a nakonec jako vedoucí bloku. Je to jedna z nejlépe placených pozic na jaderné elektrárně. Jedná se o vysoce náročnou, velmi dobře ohodnocenou, avšak rutinní činnost, kterou bych po dosažení pozice vedoucího bloku reaktoru mohl bez větší námahy vykonávat teoreticky až do důchodu.
                               ') ?>
                                <img class="ui left floated small image" src="public/images/miroslav-marik1.jpg" alt="obrazek" />
                                <?= $this->filter('e|mono|p', '
                                    Výhled na spoustu let přede mnou, kdy mě už nic moc nového nečeká, mi však připadal poněkud šedivý a málo motivující. Zároveň jsem již od mládí měl touhu cestovat a poznávat cizí země, a tak jsem po těch deseti letech využil příležitosti zapojit se do projektu Obnova systémů kontroly a řízení jaderné elektrárny (šlo o náhradu původní ruské analogové řídící techniky za francouzské digitální řídící systémy). Nastoupil jsem jako specialista pro zabezpečování kvality. Technicky jsem znal velice dobře jadernou elektrárnu, ale prakticky vůbec požadavky v této oblasti kvality. V té době se jednalo navíc o oblast, kde jednoznačný soubor závazných požadavků ani neexistoval, zavádění software do ruského systému řízení jaderné elektrárny byla úplně nová věc. Hrozilo navíc velké nebezpečí, že odpůrci jaderné energie mohou tento projekt využít jako příležitost k odstavení jaderné elektrárny. Byla to zajímavá výzva, musel jsem se hodně nového naučit, také vyjednávat a prosadit své v jednání s dodavateli i se státním dozorem a jinými útvary ČEZ, které s tím neměly zkušenost.
V průběhu práce na tomto projektu (a na následujících projektech, kde už jsem vystupoval i na straně dodavatele) jsem musel vytvářet a zavádět nové pracovní postupy, odpovídal jsem ve své oblasti za přípravu a realizaci velkých mezinárodních výběrových řízení; spolupracoval jsem s řadou dodavatelů z Francie, USA, Německa a Ruska; zajišťoval jsem přípravu a realizaci unikátního souboru hloubkových technických auditů – prostě spousta zajímavé práce se zajímavými lidmi (a samozřejmě i spousta cestování a příležitostí poznat jiné kultury).

                                    Dnes se pohybuji mezi nejlepšími světovými firmami v oboru. Člověk opravdu neupadne do stereotypu, může si vybírat nové cesty, kudy dál. Nikdy jsem nezalitoval, že jsem udělal tento krok do neznáma, kde jsem opustil teplé místo a musel se učit všechno od začátku. Přineslo mi to seberozvoj, dobrý pocit z toho, že člověk dokázal to, co před ním dosud nikdo jiný, navíc jsem viděl cizí země z jiné stránky než turista. Ve stáří asi nebudu mít pocit, že jsem něco zmeškal. Jen do toho lesa se nedostávám tak často, jak bych chtěl. Možná až v důchodu. 
                                ') ?>
                            </article>
                            <div class="ui horizontal divider">Přečtěte si také</div>
                            <?= $this->repeat('templates/main/pribehy/perex.php', $context['perexy']) ?>
                        </div>
                    </div>
