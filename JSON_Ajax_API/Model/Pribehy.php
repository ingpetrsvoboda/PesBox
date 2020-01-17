<?php
namespace Liveblock\Model;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Pribehy
 *
 * @author pes2704
 */
class Pribehy {

    const IMAGES = "public/images/";
    const MAIN_REF = "index.php?main=pribeh&pribeh=";

    private $pribehyStudentu = [
        'david_brabec' => [
            'autor' => 'David Brabec',
            'pribehPerex' => [
                'pribehyPerexImageAttributes' => ['src'=>self::IMAGES."david-brabec1.jpg", 'alt'=>"DavidBrabec"],
                'pribehyPerexTitleAttributes' => ['href'=>self::MAIN_REF."david_brabec"],
                'pribehyPerexTitleText' => "Ani handicap nemusí být překážkou",
                'pribehyPerexText' => "U digitálních generací Y a Z se mluví o důrazu na vyvážení  pracovního a osobního života, nechtějí život strávit jen prací. Žijí  intenzivně a chtějí si užívat. Stejnou hodnotu jako práce mají přátelské a rodinné vztahy, osobní svoboda, cestování. Odmítají rodičovský model, kdy práce měla často přednost před rodinou. Zkoušejí podnikat, když nenajdou práci v systému, designují si ji podle svých představ. Že je to utopie? Oslovili jsme Davida Brabce, moderátora Hitrádia FM Plus, aby nám vyprávěl svůj příběh hledání práce:",
                'pribehyPerexButtonAttributes' => ['href'=>self::MAIN_REF."david_brabec"],
                'pribehyPerexButtonText' => "Číst"
            ],
            'pribehClanek' => [
                'imgAutoraAttributes' => ['src' => self::IMAGES.'david-brabec1.jpg', 'alt' => 'David Brabec', 'class'=>'ui left floated small image'],
                'imgPribehuAttributes' => ['src' => self::IMAGES.'radio.jpg', 'alt' => 'rádio', 'class'=>'ui image'],
                'castPribehu' => 'Už od mala jsem měl velké problémy se čtením a psaním. Pokud si to dobře pamatuji, tak jsem byl vůbec poslední dítě ve třídě, které začalo psát perem. Mně to nikdy moc nešlo, ale nic jsem si z toho nedělal. Na druhém stupni základní školy mi psycholog zjistil dyslexii a dysgrafii, tedy problém se čtením a psaním (ten se projevuje i tak, že do dnes přesně nevím, jak se tahle porucha píše :)). Jenže nikdo na mě žádné velké ohledy nebral. A já ani nechtěl. Byl jsem prostě smířen s tím, že z diktátů budu dostávat jednu pětku za druhou a že na mých slohovkách bude vždy víc červené než modré barvy. Velkým vysvobozením pro mě bylo, když se přestal ve škole brát pravopis a začala se studovat literatura. Myslím, že jen díky tomu jsem z češtiny nakonec nepropadl.

Můj problém s pravopisem a čtením mě ale nezastavil. Dostal jsem se na gymnázium, kde jsme s učitelem češtiny dělali v kavárně Jabloň scénické čtení.  Předčítali jsme z knížek, které mi byly blízké, mělo to atmosféru a v publiku byli kamarádi i cizí lidi. Nikdo neutekl! ',
                'cast2Pribehu' => 'Vysokou školu jsem vybíral vylučovací metodou - nevěděl jsem přesně, co chci, ale věděl, co nechci. Nejsem technický typ, ale zase jsem neměl odpor k matice, tak mi z toho vyšla ekonomka. V prváku jsem hledal nějakou brigádu, ale nechtělo se mi dělat nekvalifikované pomocné práce. S ohledem na mé otřesné čtení se mi povedlo něco neuvěřitelného. Prošel jsem konkurzem do rádia a tahle brigáda mi vydržela celý bakalářský stupeň. Mnoho lidí to neví, ale rádio není jen o improvizaci a vyprávění spatra. Většina moderátorů svoje vstupy do éteru čte. A to tak dobře, že si lidé myslí, že mluví bez papíru.

                                        A tak jsem denně pracoval v rádiu a jezdil ve tři ráno do Prahy, abych v šest mohl popřát dobré ráno z obrazovky. K tomu jsem chodil na lekce rétoriky a začal studovat magisterský stupeň. Bylo to nadoraz a odnesla to škola. Najednou jsem měl dojem, že mi přednášky nedávají tolik jako práce samotná a přes vášnivé diskuse doma jsem pokračování školy odložil na neurčito.

                                        Dnes už se věnuji moderování 8 let. Z kluka s poruchou čtení se stal člověk, co se vlastně čtením (do určité míry) živí. Rádiu jsem zůstal věrný, moderuji různé akce, natáčím videa, věnuji se marketingu, občas učím rétoriku v kurzech. Vyhovuje mi, že si zčásti sám určuji, kdy a kolik hodin budu pracovat. Dobře to pasuje k mým dalším koníčkům, mezi které patří bojové umění bujinkan,  a ocení to i moje holka.

                                        Vlastně jsem si práci nakombinoval sám sobě na míru. Nenudím se ani minutu. A škola? Když potřebuju, dohledám kurz či přednášku na internetu. Učím se denně něco nového. Paradoxně brigáda, která mi měla pomoct získat praxi při škole, přerostla v koníčka a ten byl nakonec daleko atraktivnější než škola sama. Možná se tam někdy vrátím, až budu mít pocit, že mi přinese víc než jen titul.'
            ]
        ],
        'jan_kolmas' => [
            'autor' => 'Jan Kolmaš',
            'pribehPerex' => [
                'pribehyPerexImageAttributes' => ['src'=>self::IMAGES."jan-kolmas1.jpg", 'alt'=>"JanKolmas"],
                'pribehyPerexTitleAttributes' => ['href'=>self::MAIN_REF."jan_kolmas"],
                'pribehyPerexTitleText' => "Studium v zahraničí? Nebojte se podat přihlášku na více univerzit!",
                'pribehyPerexText' =>
                            "Jan Kolmaš je 24 letý student magisterského programu letectví a kosmonautiky na Stanford University. Už na střední škole ho bavila matematika, fyzika a chemie, ale i programování počítačů, tvorba webu, plavání a filmařina. Studovat v zahraničí nebylo jeho snem, ale v předmaturitním ročníku ho k přihláškám na zahraniční univerzity inspirovali starší spolužáci. Po celoročním snažení, skládající se z psaní esejů, standardizovaných testů a zkoušek z angličtiny, shánění doporučení a posílání přihlášek, dostal nabídku se stipendiem od Yale University, kam nakonec odjel na čtyři roky studovat na bakaláře strojního inženýrství.",
                'pribehyPerexButtonAttributes' => ['href'=>self::MAIN_REF."jan_kolmas"],
                'pribehyPerexButtonText' => "Číst"
            ],
            'pribehClanek' => [
                'imgAutoraAttributes' => ['src' => self::IMAGES.'jan-kolmas1.jpg', 'alt' => 'Jan Kolmaš', 'class'=>'ui left floated small image'],
                'imgPribehuAttributes' => ['src' => self::IMAGES.'abroad.jpg', 'alt' => 'zahraničí', 'class'=>'ui image'],
                'castPribehu' => '<b>Podle čeho jsi vybíral univerzitu, na kterou ses hlásil?</b>

Nejprve jsem vybral země, kde bych mohl studovat v angličtině nebo francouzštině. Poté jsem vybíral školy podle kvality a podle toho, jestli dávají stipendia. Nakonec jsem se hlásil na 9 univerzit v USA, na 5 v UK, na 1  Švýcarsku a 1 v Nizozemí.

                               <b>Vnímáš přijetí na prestižní univerzitu jako náhodu nebo spíš jako výsledek svého snaženi?</b>

Spíš jako náhodu, které jsem pomohl tím, že jsem se hlásil na více škol. Z devíti amerických univerzit, kam jsem se hlásil, jsem se dostal pouze na jednu. Možná zrovna hledali jednoho Čecha do jejich mixu studentů, možná se jim líbila moje přihláška, nevím.

                               <b>Litoval jsi někdy, že jsi nepokračoval na VŠ v Čechách?</b>

Určitě ne. Domů se vracím rád a jak často to jde, ale studium v zahraničí mi otevřelo úplně nové obzory.',
                'cast2Pribehu' => '<b>V čem je studium v Americe odlišné od ČR?</b>

Za prvé přístupem ke studentům. Profesoři si nemusejí dokazovat, že jsou chytřejší než student a že jich nejvíce vyhodí, ale z mé zkušenosti jim opravdu jde o to předat znalosti a aby jich co nejvíce uspělo. Například jsou velice vstřícní co se týče e-mailů nebo konzultačních hodin. Za druhé je tu systém, kde domácí úkoly a testy mají většinou váhu 60% známky, a finální zkouška, mimochodem písemná, jen 40%. Tím je stres ze školy lépe rozložený.

                               <b>Co tě nejvíc při studiu překvapilo?</b>

Osobní přístup některých profesorů. Někteří si nechají říkat křestním jménem, jiní vás pozvou na kafe, další vám zase zavolá na mobil, když se nedostavíte na hodinu.

                                <b>Musel jsi studiu něco obětovat?</b>

Osmihodinový spánek  průměrně jeden víkendový den týdně.

                                <b>Změnila tě Amerika? Pokud ano, v čem?</b>

Poznal jsem novou zemi, udělal si přátele, zlepšil si jazyk a naučil se spoustu nových věcí. Také jsem si zlepšil sebedůvěru a ujistil se, že si dokážu ve světě poradit.

                                <b>Přivydělával sis při studiu? Jaké nároky mají američtí zaměstnavatelé?</b>

Během bakaláře jsem vystřídal pár prací v rámci univerzity. Učil jsem plavání, dělal jsem plavčíka, opravoval počítače a pomáhal v designovém centru. Na magistru jsem k tomu přidal výzkumné a asistentské pozice. Zaměstnavatelé obecně předpokládají spolehlivost a oceňují iniciativu.

                                <b>V čem ti pomohla praxe?</b>

Většina předmětů je teoretická, ale některé jsou praktické ve formě projektů. Tyto předměty, dohromady s různými studentskými projekty a letní praxí mi pomohly získat praktické dovednosti, které jsou relevantní pro kariérní vývoj.

                                <b>Co bys doporučil těm, kteří by chtěli v Americe studovat?</b>

Nebát se neúspěchu a zkusit to. Vzít to vážně a začít sbírat informace. Pokud máte zájem o studium v USA tak určitě doporučuji Fulbrightovu Komisi v Praze.

                                Další mé postřehy najdete na blog.kolmas.cz. Píšu ho už šest let. '
            ]
        ],
        'lubomir_pressl' => [
            'autor' => 'Lubomír Pressl',
            'pribehPerex' => [
                'pribehyPerexImageAttributes' => ['src'=>self::IMAGES."lubomir-pressl1.jpg", 'alt'=>"LubomirPressl"],
                'pribehyPerexTitleAttributes' => ['href'=>self::MAIN_REF."lubomir_pressl"],
                'pribehyPerexTitleText' => "Lubomír Pressl, dřevorubec",
                'pribehyPerexText' =>
                            "Mým snem bylo pracovat venku, v lese nebo na poli. Nechtěl jsem být zavřený ve fabrice, to bych chcípnul! Šel jsem na střední odborné
                            učiliště v Horažďovicích, obor traktorista mechanizátor. Na tuhle školu jsem úplně nechtěl jít, ale byla to práce venku, která mne těší.",
                'pribehyPerexButtonAttributes' => ['href'=>self::MAIN_REF."lubomir_pressl"],
                'pribehyPerexButtonText' => "Číst"
            ],
            'pribehClanek' => [
                'imgAutoraAttributes' => ['src' => self::IMAGES.'lubomir-pressl1.jpg', 'alt' => 'Lubomír Pressl', 'class'=>'ui left floated small image'],
                'imgPribehuAttributes' => ['src' => self::IMAGES.'drevorubec.jpg', 'alt' => 'dřevorubec', 'class'=>'ui image'],
                'castPribehu' => 'Školu jsem dokončil s vyznamenáním a měl jsem přejít do Křimic na nástavbu na mechanizátora, ale to je práce s lidmi a to jsem nechtěl, vyzkoušel jsem si to na vojně. Šel jsem proto jako těžař s pilou do lesa nejdřív jako zaměstnanec Státních lesů. Po revoluci jsem se stal živnostníkem pro práci v lese. Znamená to, že si mne firmy najímají na konkrétní lesnické práce - kácení stromů, svážení dřeva, stavba lesních školek, prořezávání cest, sázení stromků... Baví mne práce v úkolu. Nechci se honit za kariérou.',
                'cast2Pribehu' => 'Líbí se mi na tom ta SVOBODA. Dělám podle své potřeby, nemám pevnou pracovní dobu, jsem na čerstvém vzduchu a mám klid od lidí, nemusím se s nikým dohadovat. Zadají mi práci a já ji udělám. Jsem odpovědný sám za sebe. Je zajímavé, že i když pracuji v zimě i v plískanicích, nemarodím. Ale kdykoli přijdu mezi lidi, něco chytnu. Dělám to 29 let a neměnil bych. Mám stále skvělou kondici a čistou hlavu.
                                        Žiju na vesnici v Pošumaví, mám tak čas i na svého velkého koníčka - koně a rekreační ježdění. Hodně čtu, hlavně historické romány a publikace o Šumavě. Pořád je co objevovat.'
            ]
        ],
        'marek_audes' => [
            'autor' => 'Marek Audes',
            'pribehPerex' => [
                'pribehyPerexImageAttributes' => ['src'=>self::IMAGES."marek-audes1.jpg", 'alt'=>"MarekAudes"],
                'pribehyPerexTitleAttributes' => ['href'=>self::MAIN_REF."marek_audes"],
                'pribehyPerexTitleText' => "Jděte za svým snem",
                'pribehyPerexText' =>
                            "Marek Audes, general manager AccorHotels. Na SŠ jsem nebyl jsem zrovna premiant, obchodka, kterou mi vybrali rodiče, pro mě nebyla to pravé. Moje srdce asi patřilo hotelovce... Po obchodce jsem šel na pedagogickou fakultu, ale opět to nebylo to pravé ořechové, tak jsem odešel a další rok jsem přešel na VOŠ cestovního ruchu a hotelnictví. Přitom jsem měl praxi v hotelu Plzeň jako recepční. Sem jsem také nastoupil do svého prvního zaměstnání - staral jsem se o provoz a marketing. Ta všestrannost v malém hotelu byla výborný základ.",
                'pribehyPerexButtonAttributes' => ['href'=>self::MAIN_REF."marek_audes"],
                'pribehyPerexButtonText' => "Číst",
            ],
            'pribehClanek' => [
                'imgAutoraAttributes' => ['src' => self::IMAGES.'marek-audes1.jpg', 'alt' => 'Marek Audes', 'class'=>'ui left floated small image'],
                'imgPribehuAttributes' => ['src' => self::IMAGES.'hotel.jpg', 'alt' => 'hotelnictví', 'class'=>'ui image'],
                'castPribehu' => 'Na VOŠce jsem na hodinách francouzštiny často slyšel o hotelové společnosti Accor a proto když Accor v Plzni ohlásil otevření ibisu, zájem o tuto pozici byl mojí jasnou volbou, a tak jsem se stal obchodním manažerem hotelu a prvním zaměstnancem Accoru v Plzni. Za dva a půl roku po mém nástupu francouzský kolega odešel na jinou pozici a já dostal nabídku převzít hotel jako general manager.',
                'cast2Pribehu' => 'AccorHotels mi nabídl studovat na AccorAcadémie (IHMP - international hospitality management project), která nabízí nadstandardní hotelové vzdělání. Bylo to kombinované studium v Paříži, trvalo  rok a půl. VŠ vzdělávání jsem nahradil interním studiem, ale časem s VŠ studiem do budoucna počítám. Přitom zatím nepociťuji, že by mi v mé práci chyběla, ale když se potkávám s akademickou sférou, vidím rozdíl v komunikaci.

K téhle práci potřebujete poměrně dobrou znalost cizích jazyků, chuť pracovat s lidmi a neplést do všeho své ego. Služba je od slova sloužit, to je třeba pochopit. Kdokoli někam pustí ego, je to vždycky průšvih, ať je to auto nebo hotel.

Myslím, že při hledání práce jde hlavně o motivaci - co nás živí, to by nás mělo bavit. Měli bychom mít pocit, že je to fajn práce, že ty peníze jsme vydělali příjemnou cestou a užili jsme si to. Je důležité najít si mentora, který ukáže cestu, jak fungovat v oboru. Vždycky jsem měl někoho, kdo mne správně vedl a inspiroval mne.

Moje rada je: Jděte za svým snem, poslouchejte názory svých blízkých, nebojte se výzev a jděte vždy naproti svému štěstí!'
            ]
        ],
        'marek_titl' => [
            'autor' => 'Marek Titl',
            'pribehPerex' => [
                'pribehyPerexImageAttributes' => ['src'=>self::IMAGES."marek-titl1.jpg", 'alt'=>"MarekTitl"],
                'pribehyPerexTitleAttributes' => ['href'=>self::MAIN_REF."marek_titl"],
                'pribehyPerexTitleText' => "Nebojíte se lidí? Zkuste to v obchodě!",
                'pribehyPerexText' =>
                            "Naučit se dobře prodávat přináší nejen slušné peníze, ale i radost z každodenní komunikace s lidmi. Neznamená to, že se musíte stát podomním obchodníkem a prodávat zboží od dveří ke dveřím. Obchod má v Čechách neprávem špatnou pověst, kterou mu kazí různí multileveloví prodejci či trhovci.
                            V obchodě, ať už jako zaměstnanec či živnostník, se naučíte rozumět přáním zákazníků, vyjednávat, prezentovat, poznáte, jak funguje marketing a reklama. Dobrých obchodníků je velký nedostatek a každý druhý podnik má takovou pracovní pozici vypsanou. Můžete prodávat v realitce, v obchodním řetězci, nabízet české zboží v cizině či naopak do Čech dovážet zahraniční zboží.",
                'pribehyPerexButtonAttributes' => ['href'=>self::MAIN_REF."marek_titl"],
                'pribehyPerexButtonText' => "Číst"
            ],
            'pribehClanek' => [
                'imgAutoraAttributes' => ['src' => self::IMAGES.'marek-titl1.jpg', 'alt' => 'Marek Titl', 'class'=>'ui left floated small image'],
                'imgPribehuAttributes' => ['src' => self::IMAGES.'account.jpg', 'alt' => 'obchodník', 'class'=>'ui image'],
                'castPribehu' => 'Specifická je pak práce v e-shopech, kde s klientem komunikujete hlavně přes webovou aplikaci či telefonicky. Můžete ale vymyslet vlastní e-shop a prodávat produkty či služby, ke kterým máte profesně blízko. Někteří naopak nechtějí začínat sami, ale ocení podporu zkušeného obchodníka a zázemí větší společnosti. Zajímavé je například podívat se, jaké se nabízejí franšízy (obchodní a marketingový koncept připravený k využití někým, kdo je podnikavý, ale nechce začínat od nuly s vlastním nápadem) či jaké pracovní pozice nabízejí mezinárodní obchodní řetězce. Některé nabízejí zajímavý kariérní postup těm, kteří mají tah na branku a jsou ochotni na sobě pracovat.

To, že se člověk stane úspěšným obchodníkem, často zapříčiní náhoda. Bylo tomu i v případě Marka Titla, který dnes pracuje na pozici account managera u společnosti Vodafone.

Studoval jsem gymnázium v Rokycanech a ještě při škole jsem si chodil přivydělávat do jedné firmy zabývající se IT servisem. Počítače mne vždycky bavily. Když jsem předával zákazníkům hotové zakázky, dařilo se mi ještě navíc něco prodat. Jednou mne při takovém rozhovoru se zákazníkem „nachytal“ šéf a nabídl mi pozici obchodníka. Začal jsem vydělávat daleko víc, a to se mi zalíbilo.',
                'cast2Pribehu' => 'Původně jsem se hlásil na vysokou, ale nabídka byla natolik lákavá, že jsem nastoupil do práce. Navíc jsem se pořád pohyboval v technické branži, což mi vyhovovalo. Jsem perfekcionista, vždycky jsem chtěl o zákazníkovi i obchodním případu vědět co nejvíc.  Pravda je, že jsem v práci trávil daleko víc času než mí kolegové, připravoval se na jednání, studoval technické podklady...

No a pak už chodily nabídky samy. Já jsem si nikdy práci aktivně nehledal. Ve čtyřiadvaceti jsem měl pozici šéfa obchodního týmu (area sales manager) a dělal jsem ji 6 měsíců. Mohl bych být spokojený, ale administrativní práce v kanceláři mne nebavila. Chtěl jsem být tam, kde se něco děje, u zákazníka. Když přišla nabídka z Vodafonu, šel jsem vlastně na nižší, nešéfovskou pozici. Na téhle práci se mi líbí pestrost, každý obchodní případ je jiný, žádná nuda a stereotyp.  Obchod je skvělý v tom, že nikdy předem nevíte, jak to dopadne, je tam vždycky určité napětí. Někdy dáte zákazníkovi míň informací a on je nadšený, jindy je to boj. Jasně že taky špatně snáším odmítnutí, vždycky si pak říkám, co jsem mohl udělat líp, ale to prostě patří k věci.

Je důležité, že věřím svému produktu, v jiné branži bych asi pracovat nechtěl. Líbí se mi, že tady mohu věci ovlivňovat, uplatní se tu i moje pořádkumilovnost, důslednost. Chci si být jist, že mne zákazník nenachytá na neznalosti, navíc mne těší, že nepotřebuji příliš podporu techniků.
Měl jsem i další nabídky uvnitř firmy, např. jít do mezinárodního prostředí zavádět úspěšné české projekty, ale nakonec jsem se rozhodl pro přímou práci se zákazníkem. To mne těší nejvíc. Je také pravda, že to, abych byl dobrý, mne stálo spoustu volného času, nešel jsem se koupat jako ostatní a připravoval jsem se na druhý den, ale vyplatilo se to.  Prosadit se mezi konkurencí není jednoduché. 

V obchodních pozicích se pořád dá vydělat většinou víc peněz než v jiných oborech. Nemusíte mít vysokou školu na to, abyste byli úspěšní. Naopak, schopný středoškolák používá selský rozum a neklade si zbytečné překážky. V řadě firem dnes při přijímacím pohovoru rozhoduje, zda a jakou vysokou máte a ne to, co umíte. V každé společnosti se najdou lidé na vysokých postech, kteří nemají vysoké vzdělání, ale mají např. vyvinuté sociální cítění a umí použít při důležitých rozhodnutí ,,selský“ rozum. 

Co doporučit mladým lidem, kteří chtějí zkusit obchod? Dodržujte zásady, stanovte si splnitelné a měřitelné cíle. Buďte trpěliví a cílevědomí, nikdy se nevzdávejte. A hlavně: Naučte se naslouchat!'
            ]
        ],
        'miroslav_marik' => [
            'autor' => 'Miroslav Mařík',
            'pribehPerex' => [
                'pribehyPerexImageAttributes' => ['src'=>self::IMAGES."miroslav-marik1.jpg", 'alt'=>"MiroslavMarik"],
                'pribehyPerexTitleAttributes' => ['href'=>self::MAIN_REF."miroslav_marik"],
                'pribehyPerexTitleText' => "Chtěl být hajným. Dnes vede mezinárodní týmy v jaderné energetice",
                'pribehyPerexText' => "Miroslav Mařík, dnes vedoucí pobočky ŠKODA JS na Slovensku, začal jako operátor, později dlouhé roky řídil provoz bloku v jaderné elektrárně Dukovany. Pak rutinní činnost zaměnil za kreativní práci v oblasti investičních projektů, kde získal velkou svobodu v rozhodování, možnost realizovat vlastní myšlenky a výrazně ovlivňovat práci ostatních členů týmů. Podílel se na realizaci unikátních projektů, které dosud nikdo nerealizoval. Musel zvládnout daleko víc, než běžný technik - neustále si osvojovat nové poznatky, rozlišovat podstatné od nepodstatného, vést lidi, umět komunikovat, a to i v cizích jazycích na profesní úrovni. Díky své práci cestuje po celém světě a spolupracuje se špičkovými firmami z východu i západu.",
                'pribehyPerexButtonAttributes' => ['href'=>self::MAIN_REF."miroslav_marik"],
                'pribehyPerexButtonText' => "Číst"
            ],
            'pribehClanek' => [
                'imgAutoraAttributes' => ['src' => self::IMAGES.'miroslav-marik1.jpg', 'alt' => 'Miroslav Mařík', 'class'=>'ui left floated small image'],
                'imgPribehuAttributes' => ['src' => self::IMAGES.'hajny.jpg', 'alt' => 'hajný', 'class'=>'ui image'],
                'castPribehu' => 'V dětství jsem chtěl být hajný nebo archeolog. Zjistil jsem ale, že moje představy o práci hajného se dost lišily od reality - je to víc o pěstování a těžbě dřeva než o ochraně lesa. Archeologii otvírali jednou za pár let, a tak mi táta technik poradil, že když máme jadernou elektrárnu za humny, perspektivní bude jít studovat obor energetika na VUT v Brně, který byl založen ve spolupráci s ČEZ, aby se podařilo vytipovat a připravit lidi schopné pracovat jako operátoři jaderné elektrárny. Toto povolání klade velmi vysoké nároky na psychickou odolnost, inteligenci a další vlastnosti, takže z 10 uchazečů vyhoví u přijímacích testů maximálně jeden. Zaujalo mne to.

                                    Po ukončení školy jsem další dva roky absolvoval další specializované programy završené státními zkouškami. Poté jsem cca 10 let pracoval postupně jako operátor sekundárního okruhu, operátor primárního okruhu a nakonec jako vedoucí bloku. Je to jedna z nejlépe placených pozic na jaderné elektrárně. Jedná se o vysoce náročnou, velmi dobře ohodnocenou, avšak rutinní činnost, kterou bych po dosažení pozice vedoucího bloku reaktoru mohl bez větší námahy vykonávat teoreticky až do důchodu.',
                'cast2Pribehu' => 'Výhled na spoustu let přede mnou, kdy mě už nic moc nového nečeká, mi však připadal poněkud šedivý a málo motivující. Zároveň jsem již od mládí měl touhu cestovat a poznávat cizí země, a tak jsem po těch deseti letech využil příležitosti zapojit se do projektu Obnova systémů kontroly a řízení jaderné elektrárny (šlo o náhradu původní ruské analogové řídící techniky za francouzské digitální řídící systémy). Nastoupil jsem jako specialista pro zabezpečování kvality. Technicky jsem znal velice dobře jadernou elektrárnu, ale prakticky vůbec požadavky v této oblasti kvality. V té době se jednalo navíc o oblast, kde jednoznačný soubor závazných požadavků ani neexistoval, zavádění software do ruského systému řízení jaderné elektrárny byla úplně nová věc. Hrozilo navíc velké nebezpečí, že odpůrci jaderné energie mohou tento projekt využít jako příležitost k odstavení jaderné elektrárny. Byla to zajímavá výzva, musel jsem se hodně nového naučit, také vyjednávat a prosadit své v jednání s dodavateli i se státním dozorem a jinými útvary ČEZ, které s tím neměly zkušenost.
V průběhu práce na tomto projektu (a na následujících projektech, kde už jsem vystupoval i na straně dodavatele) jsem musel vytvářet a zavádět nové pracovní postupy, odpovídal jsem ve své oblasti za přípravu a realizaci velkých mezinárodních výběrových řízení; spolupracoval jsem s řadou dodavatelů z Francie, USA, Německa a Ruska; zajišťoval jsem přípravu a realizaci unikátního souboru hloubkových technických auditů – prostě spousta zajímavé práce se zajímavými lidmi (a samozřejmě i spousta cestování a příležitostí poznat jiné kultury).

                                    Dnes se pohybuji mezi nejlepšími světovými firmami v oboru. Člověk opravdu neupadne do stereotypu, může si vybírat nové cesty, kudy dál. Nikdy jsem nezalitoval, že jsem udělal tento krok do neznáma, kde jsem opustil teplé místo a musel se učit všechno od začátku. Přineslo mi to seberozvoj, dobrý pocit z toho, že člověk dokázal to, co před ním dosud nikdo jiný, navíc jsem viděl cizí země z jiné stránky než turista. Ve stáří asi nebudu mít pocit, že jsem něco zmeškal. Jen do toho lesa se nedostávám tak často, jak bych chtěl. Možná až v důchodu. '
            ]
        ]
    ];


    /**
     *
     * @param type $pribeh
     * @return type
     */
    public function findPribehyPerexyOstatni($pribeh = "") {
        $perexy = $this->pribehyStudentu;
        if (array_key_exists($pribeh, $this->pribehyStudentu)) {
            unset($perexy[$pribeh]);
        }
        return isset($perexy) ? $perexy : [];
    }

    /**
     *
     * @param string $jmenoPribehu
     * @return array
     */
    public function getPribehStudenta($jmenoPribehu){
        if (isset($jmenoPribehu) AND array_key_exists($jmenoPribehu, $this->pribehyStudentu)) {
            return $this->pribehyStudentu[$jmenoPribehu];
        } else {
            return [];
        }
    }

    public function getPribehStudentaJson($jmenoPribehu) {
        return json_encode($this->getPribehStudenta($jmenoPribehu), JSON_FORCE_OBJECT | JSON_PRETTY_PRINT);
    }
}
