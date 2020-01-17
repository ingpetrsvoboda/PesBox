<?php

/*
 * Copyright (C) 2018 pes2704
 *
 * This is no software. This is quirky text and you may do anything with it, if you like doing
 * anything with quirky texts. This text is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

    const IMAGES = "public/images/";
    const MAIN_REF = "index.php?main=pribeh&pribeh=";

$arrayData = [
            'autor' => 'Miroslav Mařík',
            'pribehPerex' => [
                'pribehyPerexImageAttributes' => ['src'=>IMAGES."miroslav-marik1.jpg", 'alt'=>"MiroslavMarik"],
                'pribehyPerexTitleAttributes' => ['href'=>MAIN_REF."miroslav_marik"],
                'pribehyPerexTitleText' => "Chtěl být hajným. Dnes vede mezinárodní týmy v jaderné energetice",
                'pribehyPerexText' => "Miroslav Mařík, dnes vedoucí pobočky ŠKODA JS na Slovensku, začal jako operátor, později dlouhé roky řídil provoz bloku v jaderné elektrárně Dukovany. Pak rutinní činnost zaměnil za kreativní práci v oblasti investičních projektů, kde získal velkou svobodu v rozhodování, možnost realizovat vlastní myšlenky a výrazně ovlivňovat práci ostatních členů týmů. Podílel se na realizaci unikátních projektů, které dosud nikdo nerealizoval. Musel zvládnout daleko víc, než běžný technik - neustále si osvojovat nové poznatky, rozlišovat podstatné od nepodstatného, vést lidi, umět komunikovat, a to i v cizích jazycích na profesní úrovni. Díky své práci cestuje po celém světě a spolupracuje se špičkovými firmami z východu i západu.",
                'pribehyPerexButtonAttributes' => ['href'=>MAIN_REF."miroslav_marik"],
                'pribehyPerexButtonText' => "Číst"
            ],
            'pribehClanek' => [
                'imgAutoraAttributes' => ['src' => IMAGES.'miroslav-marik1.jpg', 'alt' => 'Miroslav Mařík', 'class'=>'ui left floated small image'],
                'imgPribehuAttributes' => ['src' => IMAGES.'hajny.jpg', 'alt' => 'hajný', 'class'=>'ui image'],
                'castPribehu' => 'V dětství jsem chtěl být hajný nebo archeolog. Zjistil jsem ale, že moje představy o práci hajného se dost lišily od reality - je to víc o pěstování a těžbě dřeva než o ochraně lesa. Archeologii otvírali jednou za pár let, a tak mi táta technik poradil, že když máme jadernou elektrárnu za humny, perspektivní bude jít studovat obor energetika na VUT v Brně, který byl založen ve spolupráci s ČEZ, aby se podařilo vytipovat a připravit lidi schopné pracovat jako operátoři jaderné elektrárny. Toto povolání klade velmi vysoké nároky na psychickou odolnost, inteligenci a další vlastnosti, takže z 10 uchazečů vyhoví u přijímacích testů maximálně jeden. Zaujalo mne to.

                                    Po ukončení školy jsem další dva roky absolvoval další specializované programy završené státními zkouškami. Poté jsem cca 10 let pracoval postupně jako operátor sekundárního okruhu, operátor primárního okruhu a nakonec jako vedoucí bloku. Je to jedna z nejlépe placených pozic na jaderné elektrárně. Jedná se o vysoce náročnou, velmi dobře ohodnocenou, avšak rutinní činnost, kterou bych po dosažení pozice vedoucího bloku reaktoru mohl bez větší námahy vykonávat teoreticky až do důchodu.',
                'cast2Pribehu' => 'Výhled na spoustu let přede mnou, kdy mě už nic moc nového nečeká, mi však připadal poněkud šedivý a málo motivující. Zároveň jsem již od mládí měl touhu cestovat a poznávat cizí země, a tak jsem po těch deseti letech využil příležitosti zapojit se do projektu Obnova systémů kontroly a řízení jaderné elektrárny (šlo o náhradu původní ruské analogové řídící techniky za francouzské digitální řídící systémy). Nastoupil jsem jako specialista pro zabezpečování kvality. Technicky jsem znal velice dobře jadernou elektrárnu, ale prakticky vůbec požadavky v této oblasti kvality. V té době se jednalo navíc o oblast, kde jednoznačný soubor závazných požadavků ani neexistoval, zavádění software do ruského systému řízení jaderné elektrárny byla úplně nová věc. Hrozilo navíc velké nebezpečí, že odpůrci jaderné energie mohou tento projekt využít jako příležitost k odstavení jaderné elektrárny. Byla to zajímavá výzva, musel jsem se hodně nového naučit, také vyjednávat a prosadit své v jednání s dodavateli i se státním dozorem a jinými útvary ČEZ, které s tím neměly zkušenost.
V průběhu práce na tomto projektu (a na následujících projektech, kde už jsem vystupoval i na straně dodavatele) jsem musel vytvářet a zavádět nové pracovní postupy, odpovídal jsem ve své oblasti za přípravu a realizaci velkých mezinárodních výběrových řízení; spolupracoval jsem s řadou dodavatelů z Francie, USA, Německa a Ruska; zajišťoval jsem přípravu a realizaci unikátního souboru hloubkových technických auditů – prostě spousta zajímavé práce se zajímavými lidmi (a samozřejmě i spousta cestování a příležitostí poznat jiné kultury).

                                    Dnes se pohybuji mezi nejlepšími světovými firmami v oboru. Člověk opravdu neupadne do stereotypu, může si vybírat nové cesty, kudy dál. Nikdy jsem nezalitoval, že jsem udělal tento krok do neznáma, kde jsem opustil teplé místo a musel se učit všechno od začátku. Přineslo mi to seberozvoj, dobrý pocit z toho, že člověk dokázal to, co před ním dosud nikdo jiný, navíc jsem viděl cizí země z jiné stránky než turista. Ve stáří asi nebudu mít pocit, že jsem něco zmeškal. Jen do toho lesa se nedostávám tak často, jak bych chtěl. Možná až v důchodu. '
            ]
        ];

$databaseFileName = "../database/database.json";
$json_data = json_encode($arrayData, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
file_put_contents($databaseFileName, $json_data);

$restoredData = json_decode(file_get_contents($databaseFileName), TRUE);

echo "<pre>".print_r($arrayData, TRUE)."</pre>";
echo "<pre>$json_data</pre>";
echo "<pre>".print_r($restoredData, TRUE)."</pre>";