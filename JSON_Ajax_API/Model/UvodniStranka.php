<?php
namespace Liveblock\Model;

class UvodniStranka{

    const IMAGES = "public/images/";
    const PDF = "public/pdf/";

    private $uvodniSlovo = [
        'text' => [
            'kurziva' => [
                'Fakt strávím třetinu života v práci? Nešlo by to jinak?',
                'Jak se mám vyznat na pracovním trhu?',
                'Jak vybrat ten správný obor, aby mne za pár let nenahradili roboti?',
                'Co nabízejí zaměstnavatelé v mém kraji a kde chtějí absolventy?',
                'Nemám zkusit radši podnikat?'
            ],
            'odstavec' =>
                'Na tyto a mnoho dalších otázek budoucích absolventů středních škol a učilišť odpovídá publikace
                <b>PLAV! aneb Průvodce absolventa SŠ přípravou na reálný život.</b>

                Web <b>PLAV.club</b> vznikl z podnětů jejích čtenářů, kteří si přáli některé dokumenty a odkazy najít online. Postupně budou tedy na těchto stránkách přibývat informace, které knihu doplní. Budeme rádi, když se podělíte i <a class="textovy-odkaz" href="https://goo.gl/forms/v423xnCZojrLB3lU2" target="blank">se svými zkušenostmi s hledáním zaměstnání</a> či <a class="textovy-odkaz" href="https://goo.gl/forms/vwBs11LGtwQKkEUo2" target="blank">přidáte svůj názor na přečtenou knihu</a>. Věříme, že tato stránka naplní význam své koncovky CLUB a stane se takovým klubovým sdílením informací mezi absolventy!'
        ],
        'obrazky' => [
            [
                'odkazAttributes' => ['href' => self::IMAGES.'plav-obalka.jpg'],
                'imgAttributes' => ['src' => self::IMAGES.'plav-obalka.jpg', 'alt' => 'obálka publikace']
            ],
            [
                'odkazAttributes' => ['href' => self::IMAGES.'podpora.jpg'],
                'imgAttributes' => ['src' => self::IMAGES.'podpora.jpg', 'alt' => 'podpora krajů']
            ]

        ]
    ];

    private $anotace = [
        'nazevSekce' => 'Anotace',
        'dataSekce' => [
            'odstavec' =>
                'Kniha vychází z přípravných rozhovorů a focus groups na středních školách a učilištích. Je to průvodce s vysokou informační hodnotou, psaný vtipnou formou s mnoha příklady a odkazy, které studentům pomohou v budoucím profesním životě. Na závěr jsou citovány příběhy konkrétních úspěšných lidí, které mohou pomoci motivovat mladého člověka k rozvoji kariéry. Publikace se každoročně inovuje na základě ohlasů i změn pracovního trhu. Je určena studentům i jejich rodičům a dle učitelů je využívána i při výuce společenskovědních předmětů. Kniha vychází v krajových mutacích.

                <b>Studenti posledních ročníků</b> ji dostávají ZDARMA z rukou školy díky spolupráci krajských úřadů a vydavatelství Grafia ve většině krajů ČR.

                Ostatní mají možnost si publikaci <a class="textovy-odkaz" href="https://form.simpleshop.cz/v0DP/buy/" target="blank">zakoupit</a>'
            ,
            'obrazky' => [
                [
                    'imgAttributes' => ['src' => self::IMAGES.'autorka.jpg', 'alt' => 'autorka'],
                    'pAttributes' => ['class' => 'popisek-obrazku'],
                    'popisek' => 'Autorka publikace Plav, <br/> Mgr. Jana Brabcová'
                ]
            ]
        ]
    ];

    private $tematickeOkruhy = [
        'nazevSekce' => 'Tématické okruhy',
        'dataSekce' => [
            [
                "sloupec" => [
                    'Rozhodování o budoucí profesi',
                    'Porozumět sám sobě',
                    'Volba dalšího studia',
                    'Pracovní pozice',
                    'Zaměstnání nebo podnikání?',
                    'Sebemotivace',
                    'Volba typu kariéry',
                ]
            ],[
                "sloupec" => [
                    'Práce v zahraničí',
                    'Dojíždění a teleworking',
                    'Životopis, který zaujme',
                    'Korespondence',
                    'Image a profesionální chování',
                    'Osobní komunikace, konkurs',
                    'Pohovor',
                ]
            ],[
                "sloupec" => [
                    'Work-life bilance',
                    'Právní minimum',
                    'Pár příběhů pro inspiraci',
                    'Co pomůže při rozhodování',
                    'Kapitolka pro rodiče',
                    'Doporučená literatura, odkazy',
                    'Pracovní a personální agentury',
                ]
            ],[
                "sloupec" => [
                    'Co když mne hned nevezmou?',
                    'Nástup do zaměstnání',
                    'Power talking',
                    'Komunikace s vedoucími',
                    'Základy společenského chování',
                ]
            ]
        ]
    ];

    private $ukazka = [
        'nadpisSekce' => 'Ukázka',
        'dataSekce' => [
            'obrazky' => [
                [
                    'odkazAttributes' => ['href' => self::PDF.'ukazka1.pdf'],
                    'imgAttributes' => ['src' => self::IMAGES.'ukazka1-img.jpg', 'alt' => 'ukázka z knížky'],
                    'popisek' => 'Zobrazit'
                ],
                [
                    'odkazAttributes' => ['href' => self::PDF.'ukazka2.pdf'],
                    'imgAttributes' => ['src' => self::IMAGES.'ukazka2-img.jpg', 'alt' => 'ukázka z knížky'],
                    'popisek' => 'Zobrazit'
                ],
                [
                    'odkazAttributes' => ['href' => self::PDF.'ukazka3.pdf'],
                    'imgAttributes' => ['src' => self::IMAGES.'ukazka3-img.jpg', 'alt' => 'ukázka z knížky'],
                    'popisek' => 'Zobrazit'
                ]
            ]
        ]
    ];

    private $ohlasyCtenaru = [
        'nadpisSekce' => 'Ohlasy čtenářů',
        'dataSekce' => [
            [
                'sloupec' =>[
                    [
                        'ctenar' => 'Matěj Žáček:',
                        'ohlas' => '„Moc se mi líbí, že se hodně zaměřuje na pracovní pohovor. Zatím to vypadá, že pohovor pro mě bude asi největší překážka při hledání práce,
                                    a že v tom nejsem sám. Také je dobře, že zmiňuje risk studia „zbytečných“ oborů jako antropologie, historie apod. Jedna věc,
                                    která by podle mě
                                    stála za zmínku jsou sporty a e-sporty - dnes povolání, která jsou velmi dobře placená, ale také velmi riskantní (a nezdravá)...“'
                    ],
                    [
                        'ctenar' => '4. B - Střední zdravotnická škola Jindřichův Hradec:',
                        'ohlas' => '„Myslíme si, že tato příručka pro nás byla přínosem. Před koncem studia přemýšlíme, kam půjdeme dál, jestli do školy nebo přímo do zaměstnání.
                                    Proto pro nás byla příručka rozhodně vhodná a nápomocná při rozhodování. Přiměla nás zamyslet se nad sebou samým i nad naší budoucností.“'
                    ]
                ]
            ], [
                'sloupec' => [
                    [
                        'ctenar' => 'Ing. Přikrylová, výchovná poradkyně SŠ, Olomouc:',
                        'ohlas' => '„Knihu jsem přečetla celou. Pokud si ji studenti přečtou celou, dozví se spoustu informací, na které ve škole není dostatek času ani prostor.
                                    Publikaci považuji za velmi užitečnou. Studenti se vhodně zorientují v krocích, které je čekají po studiu při hledání zaměstnání,
                                    dozví se více a zajímavou formou než ve školních předmětech Základy společenských věd nebo Ekonomika.“'
                    ],
                    [
                        'ctenar' => 'Nejvíce čtenáře zaujalo:',
                        'ohlas' => 'Dobře propracovaná kapitola První krůčky v zaměstnání. <br/>
                                    Přehledné, stručné <br/>
                                    Pár příběhů reálných lidí pro inspiraci a kapitolka pro rodiče <br/>
                                    Jak úspěšně získat zaměstnání, které chci.'
                    ]
                ]
            ]
        ]
    ];




    public function getUvodniSlovo(){
        foreach ($this->uvodniSlovo['obrazky'] as $key=>$value) {
            $this->addElementsToArrayItem($this->uvodniSlovo['obrazky'][$key]['odkazAttributes'], ["target" => "blank", "class" => "ui image"]);
        }
        return $this->uvodniSlovo;
    }

    public function getAnotace(){
        foreach ($this->anotace['dataSekce']['obrazky'] as $key=>$value) {
            $this->addElementsToArrayItem($this->anotace['dataSekce']['obrazky'][$key]['imgAttributes'], ['class'=>"ui image"]);
        }
        return $this->anotace;
    }

    public function getTematickeOkruhy(){
        return $this->tematickeOkruhy;
    }

    public function getUkazka(){
        foreach ($this->ukazka['dataSekce']['obrazky'] as $key=>$value) {
            $this->addElementsToArrayItem($this->ukazka['dataSekce']['obrazky'][$key]['odkazAttributes'], ['target' => 'blank', 'class' =>'ui large image']);
        }
        return $this->ukazka;
    }

    public function getOhlasy(){
        $model = $this->ohlasyCtenaru;
        return $this->ohlasyCtenaru;
    }

    private function addElementsToArrayItem(&$arrayItem, $addedArray) {
        $arrayItem = array_merge($arrayItem, $addedArray);
    }
}

