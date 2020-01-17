<?php

namespace Liveblock\Model;

/**
 * Description of Prace
 *
 * @author pes2704
 */
class OhlasyCtenaru {
    const IMAGES = 'public/images/';

    private $odpovedi = [
        'vystupDotazniku' => 'K 10. 4. 2017 jsme zveřejnili dotazník pro všechny, kterým se publikace PLAV dostala do rukou. O 8 dnů později jsme měli už
                              71 dotazníků vyplněných, k 12.  5. jich bylo 209. Medián hodnocení je 8 z 10 možných bodů (hodnotili studenti/absolventi, učitelé,
                              výchovní poradci, rodiče a ředitelé škol). Děkujeme všem, odpovědi nám pomáhají publikaci v příštím vydání vylepšit!',
        'dotaznik' => 'Těšíme se na další odpovědi! Vyplňte prosím <a class="styl-odkazu" href="https://goo.gl/forms/vwBs11LGtwQKkEUo2" target="blank">dotazník</a>',
        'sectionGraf' => [
            'nadpis' => 'Kdo odpovídal',
            'odkazAttributes' => ['href' => self::IMAGES.'dotaznik.jpg','class' => 'ui large image', 'target' => 'blank'],
            'imgAttributes' => ['src' => self::IMAGES.'dotaznik.jpg', 'alt' => 'graf vyhodnocení dotazníku'],
            'odkazText' => 'Zvětšit graf'
        ],
        'sectionOdpovedi' => [
            'nadpis' => 'Odpovědi bez cenzury',
            'dataOdpovedi' => [
                    [
                    'idOtazky'=>'1',
                    'otazka' => 'Jaké využití podle Vás publikace Plav má?',
                    'progressOdpovedi' => [
                        [
                            'progressOdpovediNazev' => 'Informativní',
                            'progressOdpovediAttributes' =>  ['data-percent' => '44']
                        ],
                        [
                            'progressOdpovediNazev' => 'Pro absolventy SŠ',
                            'progressOdpovediAttributes' =>  ['data-percent' => '28']
                        ],
                        [
                            'progressOdpovediNazev' => 'Praktické rady do života',
                            'progressOdpovediAttributes' =>  ['data-percent' => '17']
                        ]
                    ],
                    'topDeset' => [
                        'pro soukromé využití žáků, ve výuce předmětů ekonomika a občanská nauka, v práci kariérového poradce, pro rodiče',
                        'Dobrá publikace pro absolventy SŠ, kteří se nemohou rozhodnout jak dál po škole',
                        'Je vhodná pro lidi kteří nemají představu o tom jak se uvést v práci, jak získat práci a jak v ní fungovat.',
                        'Když poprvé hledám práci a nevím do čeho jdu, nebo když člověk dlouho nemůže nějakou práci najít. Dala by se využít ve škole při výuce ekonomiky.',
                        'Nabídne žákům, jak zvládat přípravu na pracovní proces',
                        'dobrý start do života',
                        'po maturitě bych se na ni určitě rád podíval, abych věděl co dál',
                        'široké',
                        'pro budoucí práci',
                        'uvedení do budoucího života',
                    ],
                    'dalsiOdpovedi' => [
                        'Aktuální informace do pracovního procesu.',
                        'Bohužel jsem ji ještě nečetl. Ale předpokládám, že by měla pomoci absolventům středních škol,
                         kteří již dále nehodlají pokračovat ve studiu a chystají se využít své znalosti a dovednosti v praxi.',
                        'byla opravdu poučná, pomůže všem, co mají dělat v takových situacích jak správně se zachovat',
                        'celkový přehlad a motivace do dalšího studia',
                        'Dává absolventům SŠ a SOU informace o možnostech hledání pracovního místa, komunikace a vystupování s zaměstnavatelem',
                        'dává velmi dobrý návod k tomu, aby člověk porozuměl sám sobě a vhodnými metodami našel povolání a uplatnění v životě',
                        'Dle mého názoru, je prospěšná především pro studenty, kteří končí (nebo v blízké době budou končit) střední školu.
                         Je v ní mnoho užitečných věcí, které jim pomohou v dalším studiu nebo při hledání práce.
                         O spoustě z nich třeba slyší poprvé. Dá se využít i ve výuce. Jak už jsem výše zaškrtla,
                         stojí za to, aby si ji pročetli i rodiče nebo učitelé na školách.',
                        'Dobrá publikace pro absolventy SŠ, kteří se nemohou rozhodnout jak dál po škole',
                        'Moc jich nebude. Je příliš obsáhlá a nepoutavá.',
                        'dobré pro orientaci v reálném životě po dokončení střední školy',
                        'Nevím, nečetl jsem.',
                        'Důležité informace, co se životem, když se např. nedostaneme na VŠ, nemůžeme sehnat práci atd.',
                        'Hlavně jako praktická příručka pro studenta přemýšlejícího o své profesní kariéře a pro absolventa SŠ, VOŠ, VŠ nastupujícího do praxe.',
                        'Hodí se lidem, kteří se poprvé ucházejí o pracovní místo a lidem, kteří neví, co od zaměstnání a zaměstnavatele v prvních chvílích očekávat.',
                        'Hodně hrubý úvod do pracovního prostředí.',
                        'Jako seznámení s okolním světem v rozumné formě. Žáci si brožury pročetli a komentovali způsobem jim vlastním.',
                        'Je inspirující, přehledná, jasná - využití při výuce, přednáškách, seminářích - pokud možno nejen "rozdat" bez komentáře,
                         ale používat místo tradičních powerpointovských prezentací, využít i pro práci s textem, vzorové zadání např. i pro slohovku (dopis sobě...).',
                        'Je to souhrn informací',
                        'Je vhodná k pomoci při hledání pracovního místa',
                        'je vhodné si ji přečíst a udělat si vlastní názor na zmíněné věci',
                        'K přípravě na vstup do pracovního života, k přípravě na Závěrečné zkoušky u učebních oborů - Otázky ze světa práce.',
                        'kariérní poradenství',
                        'Každá taková publikace je důležitá!',
                        'Když poprvé hledám práci a nevím do čeho jdu, nebo když člověk dlouho nemůže nějakou práci najít. Dala by se využít ve škole při výuce ekonomiky.',
                        'ke čtení',
                        'Kniha by nám měla pomoci se správným postupem při hledání práce. Jak by měl vypadat pohovor, životopis...',
                        'Kniha poukazuje na možnosti, ale i výhody a nevýhody zaměstnání, dále např. rady při podpisu pracovní smlouvy a nástupu do zaměstnání a jiné.',
                        'malé',
                        'Může pomoci absolventům s volbou další dráhy.',
                        'Může pomoct v rozhodnutí těch, kteří si stále nejsou jistí co chtějí po škole dělat. A nebo pomoct v určitých situacích
                         (např. návod jak se chovat při pohovoru)',
                        'Myslím, že se publikace dá vyyužít jakkoliv a kdykolov.',
                        'Myslím, že to je velice skvělý nápad. Škoda, že v roce, kdy jsem absolvovala střední školu taková naučná brožura nebyla.',
                        'Nabídne žákům, jak zvládat přípravu na pracovní proces',
                        'Napoví lidem, jakou cestou mají lidé (studenti) dál jít. Na co si mají dát pozor v práci, co je může potkat.',
                        'O publikaci nic nevím.',
                        'obeznámit studenty s tím, co je čeká v nejbližší budoucnosti',
                        'omezené',
                        'orientace absolventa při výběru povolání',
                        'Orientace v možnostech.',
                        'podává informace o zaměstnání, benefitech zaměstnavatele, korespondence se
                         změstnavarelem, smlouvy, první reakce na získané místo = průvodce zaměstnáním',
                        'Podle mého názoru publikace PLAV nemá žádné využití.',
                        'Podpůrný materiál pro výchovného poradce.',
                        'podpůrný materiál ve výuce',
                        'Pokud si ji studenti přečtou celou, dozví se spoustu informací, na které ve škole není dostatek času ani prostor. ',
                        'Pro budoucí práci',
                        'Pro informování studentů.',
                        'Pro některé absolventy se mi jeví jako velmi přínosná, protože i když se z nich stanou absolventi ,
                         němá ještě řada z nich jasnou představu o své budoucnosti.',
                        'Pro orientaci a odpovědné chování v životě po obsolvování školy. Srozumitelné pro mladé lidi.',
                        'pro předmět občanská výchova',
                        'pro studenty co hledají práci',
                        'Pro studenty kteří neví po ukončení školy kde pracovat, jak pokračovat.',
                        'pro studenty, seznamuje je s reálným životem, co se ve škole neučí',
                        'Při práci se studenty 4. ročníků jsem vycházela z některých informací',
                        'Při výuce občanské nauky, ekonomiky, základů společenských věd.',
                        'příprava a praktické info na období mezi SŠ a nástupem do zaměstnání',
                        'příprava do života, pomoc při hledání zaměstnání, zkušenosti',
                        'Připravuje studenty na opravdu reálný pracovní život. Radí, pomáhá a připravuje.',
                        'Publikace byla předána žákům posledních ročníků k získání lepší orientace při vstupu do pracovního života.',
                        'Publikace je vhodná pro žáky končících ročníků. Najdou tam vhodné informace pro uplatnění v praxi, atd...',
                        'Publikace je vhodná pro žáky posledních ročníků, aby se připravili na vstup do zaměstnání.',
                        'Publikace nabízí odpovědi na otázky, které si klade většina středoškoláků. Oceňuji nejen teoretické části,
                         ale především množství praktických rad a příběhů.',
                        'Publikace najde své využití u absolventů, kteří nevědí, jak se připravit na zaměstnání, jak se chovat u konkurzu,
                         jak jednat s potencionálním zaměstnavatelem, jak sestavit životopis...',
                        'Publikace Plav! je velmi dobře uspořádaným zdrojem informací pro všechny žáky, kteří míří do pracovního procesu. Já ji využívám i jako
                         podpůrnou publikaci při výuce personalistiky a dovedu si představit i využití pro kariérní poradce, pro učitele českého jazyka i pro výchovné poradce.',
                        'Publikaci jsem pouze prolistoval, nečetl jsem ji',
                        'Publikaci obdržel v naší škole každý žák 4. ročníku. Mnohé žáky obsah publikace zaujal a pročítali ji.
                         Každý měl možnost vyhledat si v publikaci dle obsahu informaci, která byla pro něj momentálně aktuální.',
                        'Publikaci PLAV jsem pouze prolistoval.',
                        'Radce, pomoc pri prijimacim pohovoru, pri sestavovani životopisu, jak a kde hledat vhodné zamêstnání, první krůčky v nové práci.',
                        'Vhodné do výuky ekonomiky, občanské výchovy, česky jazyk a literatura, managment, do trídnických hodin, pro výchovného poradce.',
                        'Raději ani nečíst. Nevím, jestli je to myšleno vážně, nebo jako ironie.',
                        'Rady do života.',
                        'Rady jak porozumět sám sobě, vybrat si práci která baví a dává smysl. Užitečné návody jak se ucházet o místo a obstát. První krůčky v zaměstnání.
                         Všechny informace pohromadě. Je to praktická příručka užitečná pro všechny, zejména absolventy, kteří o svém životě teprve rozhodují.',
                        'Rozhodně poučné i naučné. Dobré typy a rady.',
                        'Rozšiřuje možnosti orientovat se na trhu práce.',
                        'Rozšiřuje vtipně obzory mladých ohledně jejich budoucnosti.',
                        'seznámení s možnostmi případné kariéry',
                        'Seznámení studentů s životem po škole',
                        'Seznámení žáků s tím, co je čeká po studiu, možnost využití v ekonomii, občanské výchově, při třídnických hodinách',
                        'Umožnuje nám vstup do reálného života. Dobré zkušenosti pro život.',
                        'Určitě je pro budoucí absolventy velice přínosná se svými radami a na jaká úskalí si dát pozor,
                         zajímavé např: pracovní agentury, právní minimum, určitě jsou vhodné skutečné příběhy.',
                        'Určitě bych úvítala i v dalších letech poskytnout vycházejícím žákům.',
                        'určitě nějaké',
                        'Určitě pro další orientaci studentů a také pro výchovné poradce, aby dokázali svým studentům poradit.
                         Také pro rodiče studentů a samozřejmě i pro samotné studenty.',
                        'usnadnění etapy hledání zaměstnání a prvních kroků v zaměstnání',
                        'uvedení do budoucího života',
                        'Užitečné',
                        'užitečné informace po ukončení střední školy',
                        'V době internetu nemá víceméně žádné využití, takže já osobně ji použiji na „podpálku“. Škoda stromů, kteří pro tuto knihu byly pokáceny.',
                        'V hodinách občanské výchovy, v osobnostním rozvoji žáků, třídnických hodinách....',
                        'v občaske vychove . třídncích hodinach ....',
                        've výuce',
                        'Vhodné pro absolventy SŠ, kteří se zde dozví zajímavé informace o získání práce.',
                        'vhodné pro práci výchovného poradce, třídních učitelů, učitelů občanské výchovy a k přípravě k závěrečným zkouškám - otázky ze světa práce',
                        'Vhodné pro studenty, kteří hodlají po SŠ pracovat.',
                        'Volba povolání, příprava do dalšího života',
                        'Vtipně psaný návod pro absolventy středních škol a učňovských oborů - jak se lépe přehoupnout ze školních lavic do pracovního života. Rady, návody....',
                        'Výborné pro studenty kteří ukončili školu a neví jak dal.',
                        'Výborný doplněk pro budoucí absolventy....shrnující informace ohledně kariérového poradenství....publikace vhodná i pro učitele i pro veřejnost',
                        'Výborný způsob plýtvání peněz ze státního rozpočtu.',
                        'vyšší informovanost pro VP i absolventy',
                        'Využije ji žák SŠ a SOU',
                        'učitel pro přehledné uspořádání témat světe práce',
                        'Využití jako příprava pro uplatnění se na pracovním trhu.',
                        'Využití má pro studenty, kteří nevědí co s životem pro absolventy SŠ či SOU. Mohou v ní získat různé rady...',
                        'Využití pro ujasnění chování v budoucím životě, k lepšímu jednání při sháňce zaměstnání.',
                        'využití při hledání zaměstnání - dobře popsán motivační dopis spolu s životopisem,
                         jaké náležitosti by měl mít a jaké naopak ne, otázky, které často kladou zaměstnavatelé při pohovoru',
                        'Využití při realizaci průřezových témat člověk a svět práce.',
                        'Využití ve výuce u témat týkajících se uplatnění na trhu práce, na naší škole se vyučují v rámci předmětu Ekonomika.',
                        'Vzdělávací',
                        'základní infomace pro budoucí absolventy školy',
                        'Založení ohně v krbu.',
                        'Zejména díky užitečným informacím, lze považovat brožura za pomocníka a rádce pro život po ukončení střední školy,
                         a zároveň i pro studenty vysokých škol, kterým se nevydařilo studium VŠ.',
                        'Získání informací, kam po škole. Rady do života.',
                        'Získání základních informací pro žáky co dělat po ukončení vzdělávání.',
                        'Získávání aktuálních informací v ekonomice, společenském kontaktu, návody a rady při hledání zaměstnání.',
                        'Znamená shrnutí základních informací, které by jinak musel absolvent SŠ dohledávat osobně, tj. ne vždy
                         kvalitně - její význam tedy vidím hlavně v zajištění kompetentní informovanosti cílové skupiny.',
                    ],
                ],[
                    'idOtazky'=>'2',
                    'otazka' => 'Nejvíce mne zaujalo:',
                    'progressOdpovedi' => [
                        [
                            'progressOdpovediNazev' => 'Vzorové životopisy',
                            'progressOdpovediAttributes' =>  ['data-percent' => '35']
                        ],
                        [
                            'progressOdpovediNazev' => 'První krůčky v zaměstnání',
                            'progressOdpovediAttributes' =>  ['data-percent' => '29']
                        ],
                        [
                            'progressOdpovediNazev' => 'Příběhy ze života',
                            'progressOdpovediAttributes' =>  ['data-percent' => '18']
                        ]
                    ],
                    'topDeset' => [
                        'Pár příběhů reálných lidí pro inspiraci a kapitolka pro rodiče',
                        'Pracovní pohovory a jejich vedení',
                        'Nejvíce mě zaujala kapitola "Jak být jiný, aby si mě všimli a vybrali"',
                        'graficky přehledné zpracování publikace',
                        'bylo toho víc',
                        'Práce v zahraničí.',
                        'Orientace na trhu práce',
                        'možnost jednání s odbornými poradci',
                        'Image a profesionální chování,',
                        'pozor na paragrafy - co jsem podepsal!!!!!!!',
                    ],
                    'dalsiOdpovedi' => [
                        'Celkem vhodné a promyšlené příklady, odpovědi na dotazy apod. které asi žádná praktická příručka doposud neřešila, ovšem v této části
                         se to dá dále rozšiřovat a vylepšovat. Některé pasáže nám připadají jako obecné konstatování bez jednoznačného stanoviska,
                         co se doporučuje resp. co je vlastně správně, přestože se to dá určit bez polemiky.',
                        'Jak už jsem se zmínila, nejvíce mne zaujaly kapitoly o tom, jak úspěšně získat zaměstnání, které chci.',
                        'Kapitola "Kdo jsem a kam směřuji.", kapitoly o volbě dalšího studia a pracovní kariéry, praktické rady pro uchazeče o zaměstnání.',
                        'kapitola benefity - velmi komplexní a podrobné, reálné příběhy skutečných lidí (svědectví)',
                        'dopis sobě, příběhy konkrétních lidí',
                        'nečetla - neumím posoudit',
                        'pracovněprávní tématika, společenské chování',
                        'Návod pro správné a profesionální chování uchazečů o zaměstnání, přijímací pohovor.',
                        'kapitoly: profesionální chování, často kladené dotazy u přijímacího pohovoru, právní minimum, první krůčky v zaměstnání',
                        'věty typu... "nic lepšího než práce stejně nezbývá." To má jako studenty od práce odradit?Zní to jako že práce je až to poslední,
                         co bychom měli dělat. Kniha radí, že .."kdo nechce jít pracovat, má jít dál studovat." To mám být motivace k dalšímu vzdělávání?
                         Jsi líný jít dělat, tak se jdi flákat do školy? Opravdu mi to připadá velmi podivné.',
                        'návod jak v jednotlivých situacích reagovat a chovat se',
                        'nevím',
                        'Přehledné, stručné',
                        'postup při hledání zaměstnání',
                        'téma',
                        'Popis vzorových situací a reakcí na chování okolí.',
                        'dopis sobě, příběhy konkrétních lidí',
                        'výběr budoucího povolání',
                        'Všechny kapitoly',
                        'Příběhy reálných lidí, plánování vlastního času, jak být jiný.',
                        'graficky přehledné zpracování publikace',
                        'péče o studenty',
                        'Studenti se vhodně zorientují v krocích, které je čekají po studiu při hledání zaměstnání, dozví se více
                         a zajímavou formou než ve školních předmětech Základy společenských věd nebo Ekonomika.',
                        'Co když mne hned nikde nevezmou?',
                        'Pár reálných příběhů lidí.',
                        'snaha dostat do průvodce informace komplexní (tedy prakticky využitelné - např životopis a weby,
                         z oboru psychologie, motivační ...). Snaha poskytnout celkový obraz o "budoucnosti."',
                        'zaklepat a vstoupit, Co jsem podepsal - právní minimum',
                        'Velmi dobré a konkrétní příklady otázek a odpovědí z přijímacích pohovorů.',
                        'Přehlednost publikace.',
                        'Čtivost pro žáky - dobře zpracováno!',
                        'Rady, na co se ptají budoucí zaměstnavatelé, jak na ně odpovídat, jak se chovat...',
                        'první dojem (např.zaklepat a vstoupit)',
                        'orientace při rozhodování se a výběr zaměstnání',
                        'základ ve společenském chování, vhodnost oblečení pro různé akce',
                        'Jak vest hovor s šéfy - možná více pokory, rozvrh a využívání času.',
                        'jaké otázky očekávat při pohovoru, co dělat a nedělat',
                        'pracovněprávní tématika, společenské chování',
                        'Části zabývající se psychohygienou, plánováním práce, způsoby správné komunikace a autoevaluace',
                        'Co Vás čeká  zaměstnavatele?',
                        'pohled na pracovní proces z pozice zaměstnance, ale i zaměstnavatele',
                        'osobní příběhy',
                        'Návod pro správné a profesionální chování uchazečů  zaměstnání, přijímací pohovor.',
                        'Soupis potřebných dokumentů pro úvodní korespondenci se zaměstnavatelem',
                        'možnost jednání  odbornými poradci',
                        'Odpovědi na časté dotazy absolventů',
                        'nemá vyhraněný názor',
                        'Jednoduchost s jakou byly objasněny složité situace při hledání práce. Takto to pochopí opravdu každý.',
                        'šíře informací',
                        'dost kapitol',
                        'reálný pohled',
                        'Co mohu nabídnout zaměstnavateli, jak pracovat u zaměstnavatele, skutečné příběhy.',
                        'Orientace na trhu práce',
                        'návod jak v jednotlivých situacích reagovat a chovat se',
                        'informace o životopisu, příběhy',
                        'kapitoly: profesionální chování, často kladené dotazy u přijímacího pohovoru, právní minimum, první krůčky v zaměstnání',
                        'vzorový životopis, kladné otázky u pohovorů, první dojem při pohovoru...atd...',
                        'příklady CV, motivačních dopisů atd.',
                        'informace týkající se přijímacího pohovoru',
                        'Kapitola pracovní smlouva, účast v konkurzu.',
                        'Pasáže věnované výběrovému řízení a "prvním krůčkům v zaměstnání".',
                    ]
                ],[
                    'idOtazky'=>'3',
                    'otazka' => 'Za užitečné informace považuji:',
                    'progressOdpovedi' => [
                        [
                            'progressOdpovediNazev' => 'Jak se chovat na pohovoru',
                            'progressOdpovediAttributes' =>  ['data-percent' => '32']
                        ],
                        [
                            'progressOdpovediNazev' => 'Vše',
                            'progressOdpovediAttributes' =>  ['data-percent' => '31']
                        ],
                        [
                            'progressOdpovediNazev' => 'Životopis',
                            'progressOdpovediAttributes' =>  ['data-percent' => '27']
                        ]
                    ],
                    'topDeset' => [
                        'aktualizované požadavky trhu práce',
                        'Analýza a prezentace sama sebe. Chování v novém prostředí po skončení školy.',
                        'Co dělat po škole',
                        'co dělat v různých životních situacích',
                        'domluva v práci',
                        'ekonomické pojmy',
                        'finanční gramotnost',
                        'chování u konkurzu',
                        'info o pracovním pohovoru a o daních',
                        'Komplexnost a sourodost informací v návaznosti na uplatnění v praxi i v životě na jednom místě s možností se k některým otázkám
                         podle potřeby vracet, praktické příklady a dotazy k zamyšlení',
                    ],
                    'dalsiOdpovedi' => [
                        'Např právní minimum, informace o práci v zahraničí aj.',
                        'Na čem všem záleží, aby člověk byl přijat.',
                        'Nepamatuju si již publikaci',
                        'obecně všechny',
                        'Psychologie žáka',
                        'sebemotivaci, co když mě nikde nevezmou, první krůčky v zaměstnání',
                        'Úplně vše co je v publikaci.',
                        'Slova učitelů',
                        'komunikace s budoucím zaměstnavatelem',
                        'konkrétní rady pro uchazeče o zaměstnání, reálné životní příběhy',
                        'Motivace, vstup do zaměstnání',
                        'možnosti kariérního růstu',
                        'možnosti nalezení práce',
                        'některé pasáže ze zákona',
                        'úplně všechny',
                        'Nemohu posoudit',
                        'Nepamatuju si již publikaci',
                        'V každé kapitole jsou uvedeny užitečné informace',
                        'ohledně trhu práce',
                        'poznání sama sebe',
                        'moderní flexibilní formy práce',
                        'motivační dopis',
                        'nevím',
                        'Nic',
                        'o budoucnosti, práci',
                        'popis jak se chovat při pohovoru se zaměstnavatelem. Často mkladené otázky u přijímacích pohovorů. První krůčky v novém zaměstnání,...',
                        'o práci',
                        'obecné',
                        'odpovědi na dotazy absolventů. příběhy reálných lidí pro inspiraci',
                        'první krůčky v zaměstnání',
                        'REJSTŘÍK ZAMĚSTNÁNÍ',
                        'orientace v dalším životě',
                        'obeznámení s tím, čemu se nevyhneme',
                        'otázky a odpovědi',
                        'pojmy z pracovního procesu',
                        'pomoc např. s napsáním motivačního dopisu',
                        'pomoc s výběrem vysoké školy',
                        'Pomoc se životopisem.',
                        'o finanční gramotnosti apod',
                        'Popis kroků při volbě a nástupu do zaměstnaní.',
                        'Postup při získání pracovního místa',
                        'použitelné v praxi',
                        'orientace na trhu práce',
                        'Poznání sama sebe. Zajímavé je všechno.',
                        'ty co tam jsou',
                        'pracovně právní vztahy',
                        'pracovní pohovor',
                        'Praktické příklady, reálné příběhy mladých lidí',
                        'Rady do života ohledně budoucího zaměstnanání',
                        'právní info',
                        'právní minimum',
                        'Prezentování sebe samého.',
                        'Prakticky vše obsažené v publikaci je užitečné.',
                        'průvodní dopis,psaní životopisu',
                        'přehled',
                        'orientace',
                        'přehled možností',
                        'příběhy ze života',
                        'Příprava na pohovor',
                        'Rady a informace',
                        'rady do života',
                        'různé zajímavosti',
                        'seznámení s realitou, úplnost informací',
                        'skoro nic',
                        'Především kapitoly jak porozumět sám sobě a o volbě práce. Také co dělat, abych měla co největší úspěšnost přijetí.',
                        'start do práce',
                        'Poznání sama sebe. Vše je užitečné.',
                        'Stručnost a jasnost podání informací.',
                        'struktura životopisu',
                        'téma',
                        'téměř všechny, které jsou uvedeny v brožuře',
                        'toho je spousta',
                        'uvedené webové stránky, praktický přístup',
                        'Nepovažuji za užitečné informace nic.',
                        'V podstatě vše, zejména konkrétní návody pro orientaci na trhu práce.',
                    ]
                ],[
                    'idOtazky'=>'4',
                    'otazka' => 'Použili jste publikaci ve výuce? Pokud ano, jak?',
                    'progressOdpovedi' => [
                        [
                            'progressOdpovediNazev' => 'Ano',
                            'progressOdpovediAttributes' =>  ['data-percent' => '39']
                        ]
                    ],
                    'topDeset' => [
                        'ano - ekonomika, výběr a praktické zaměření hodin na daná témata.',
                        'Ano s žáky jsem si ve vyučování knihu prošla a upozornila je na jednotlivé články.',
                        'ano, citovala jsem některé pasáže studentům',
                        'K prolistování',
                        'jen jsem na ni žáky upozornil',
                        'Český Jazyk, životopis',
                        'Konzultace, výklad, praktická ukázka.',
                        'výtah z publikace',
                        'Zatím ne ale pripravuji se na to v pristim roce, kdy budu mít treťáky',
                        'žáci s ní společně se mnou pracovali',
                    ],
                    'dalsiOdpovedi' => [
                        'Jako názornou pomůcku při tvorbě životopisu.',
                        'na studentské radě - informace o vtisku, seznámení s obsahem',
                        'Některá témata probíráme. Bohužel, neobdrželi jsme brožurku v dostatečném množství. Rozdali jsme ji žákům a pro vyučující nezbylo.',
                        'nikdy, možná, jako odstrašující příklad',
                        'prozatím ne, až se s ní více seznámím, pak jistě ano',
                        'třídnická hodina',
                        'V třídnických hodinách , dizkuze o dalším uplatněního',
                        'výkladově a komunikačně',
                        'Vzhledem k tomu, že obsah příručky se shoduje s tématy předmětu Ekonomika - Pracovněprávní vztahy a související činnosti - ANO',
                        'Zatím ne, ale použiju ji.',
                        'Dostali jsme přesný počet výtisků pouze pro žáky 4. ročníku s instrukci o předání těmto žákům.
                         Avšak obsah brožury předkládáme žákům v besedách se zástupci praxe a je součástí vybraných předmětů.',
                        'v českém jazyce vzor životopisu a průvodního dopisu',
                        'V hodinách ekonomiky - umožnila mi víc se věnovat diskusi a příkladům - žáci si nemuseli psát tolik poznámek,
                         protože měli publikaci k dispozici. Rovněž v TC Management - pyramida potřeb.',
                        'bohužel přišla až po probraném učivu',
                        'besedy o dalším uplatnění absolventů',
                        'dotazy na knihu, prezentované žáky.',
                        'jak žádat o zaměstnání',
                        'jen jsem ji rozdal žákům',
                        'k přípravě na ZZ',
                        'Navrhovala jsem využití v českém jazyce, občanské nauce a ekonomice',
                        'podpora žákům',
                        'použila jsem ji jako výchovná poradkyně',
                        'Při tvorbě životopisu',
                        'Informace o trhu práce, uzavírání pracovního poměru, osobní pohovor uchazečů o zaměstnání apod.',
                        'při výuce ekonomie u 3. ročníků učebních oborů',
                        'Ne přímo ve výuce - publikaci jsem předal studentům ve výstupních ročnících s výzvou,
                         aby mě jako kariérního poradce v případě potřeby konzultace kontaktovali v této věci osobně.',
                        'Aktuální info.',
                        'při vyučování pracovního práva',
                        'Rozbor kapitoly - První krůčky v zaměstnání',
                        'Seznámení s bružurou.',
                        'v hodině ekonomiky',
                        'při výuce občanské výchovy',
                        'seznámili jsme studenty',
                        'ukázka přijímacího pohovoru',
                        'Ukázkami',
                        'při třídnické hodině',
                        'základní informace v tématu ZSV - kam po škole',
                        'ukázky jako motivaci',
                        'upozornění na informace v ní obsažené',
                        'V hodinach občanské nauky nebo kdekoli jinde.',
                        'v OBV',
                        'vzorový životopis, průvodní dopis, přijímací pohovor, často kladené dotazy absolventů',
                        'Při přípravě na slohovou práci - motivační dopis',
                        'Zařazeno do hodin občanské nauky a pro práci VP.',
                        'Zatím ne ale pripravuji se na to v pristim roce, kdy budu mít treťáky.',
                    ]
                ]
            ]
        ]
    ];

    public function getOdpovedi(){
        return $this->odpovedi;
    }
}
