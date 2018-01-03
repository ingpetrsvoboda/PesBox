<?php

######### DEVELOPMENT A PRODUCTION GLOBALS #################

## INFO ##
## Pokud před voláním Bootstrap.php (resp. GlobalsSet.php) nastavíme hodnotu 
## globální proměnné $GLOBALS['force_production'] nebo $GLOBALS['force_development']
## použijí se tyto hodnoty místo hodnot načtených ze systémových proměnných.
## $GLOBALS['force_production'] má přednost (vyšší prioritu) než $GLOBALS['force_development'], to znamená, 
## že nastavení libovolné hodnoty proměnné $GLOBALS['force_production'] způsobí přepnutí do production modu 
## bez ohledu na $GLOBALS['force_development'].
##########

// Nastavení $GLOBALS['development'] na jakoukoli neprázdnou hodnotu MUSÍ pro skripty znamenat, že se jedná o běh ve vývojovém prostředí. 
// Pak se například mohou zobrazovat chyby apod.
// Nastavení $GLOBALS['production'] na jakoukoli neprázdnou hodnotu MUSÍ pro skripty znamenat, že se jedná o běh v produčním prostředí. 
// Pak se například mohou chyby potlačovat, nezobrazovat uživateli a pouze logovat.
// Užití obou proměnných současně se vylučuje. 
// Pokud není nastavena ani proměnná $GLOBALS['development'] ani $GLOBALS['production'], skripty NESMÍ fungovat jako by se jednalo o vývojové prostředí.

// Zde je nastavena hodnota $GLOBALS['development'] a $GLOBALS['production'] 
// - nejprve podle hodnot $GLOBALS['force_production'] nebo $GLOBALS['force_development'], ty slouží pouze k vynucení chování v průběhu vývoje pro otestování funkčnosti přepínání mezi development a production chováním, 
// - podle systémové (nestačí uživatelská) proměnné prostředí development (case insensitive) a systémové (nestačí uživatelská) proměnné prostředí production (case insensitive)

if (isset($GLOBALS['force_production'])) {
    $GLOBALS['production'] = $GLOBALS['force_production'];
    $GLOBALS['development'] = FALSE;
} elseif (isset($GLOBALS['force_development'])) {
    $GLOBALS['development'] = $GLOBALS['force_development'];
    $GLOBALS['production'] = FALSE;
} else {
    $GLOBALS['production'] = getenv('production');  // Windows - musí být nastavena systémová (nestačí uživatelská) proměnná prostředí developmentc
    $GLOBALS['production'] = FALSE;
    // $GLOBALS['development'] lze nastavit jen pokud není nastaveno $GLOBALS['production'] - chybné nastavení obou proměnných by mohlo vést k nepředpokládaným efektům
    if ($GLOBALS['production']) {
        $GLOBALS['development'] = FALSE;        
    } else {
        $GLOBALS['development'] = getenv('development');  // Windows - musí být nastavena systémová (nestačí uživatelská) proměnná prostředí production (case insensitive)    
    }
}

