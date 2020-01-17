<?php

namespace Liveblock\Model;

/**
 * Description of Prace
 *
 * @author pes2704
 */
class Kraje {

    const MAPA_IMAGES_PATH = "public/images/mapa/";

    private $defaultQueryVariables = ["main"=>"prac_mista"];

    private $vyberKraje = [
            'nadpisSekce' => 'Které firmy ve vašem kraji nabízejí místa pro absolventy?',
            'seznamKraju' => [
                    [
                        "id" => "plzensky",
                        "nazevKraje" => "Plzeňský kraj",
                        "imgAttributes"=>["src"=>self::MAPA_IMAGES_PATH."plzensky.png", "alt"=>"Plzeňský"],
                    ],
                    [
                        "id" => "praha",
                        "nazevKraje" => "město Praha",
                        "imgAttributes"=>["src"=>self::MAPA_IMAGES_PATH."praha.png", "alt"=>"Praha"],
                    ],
                    [
                        "id" => "jihocesky",
                        "nazevKraje" => "Jihočeský kraj",
                        "imgAttributes"=>["src"=>self::MAPA_IMAGES_PATH."jihocesky.png", "alt"=>"Jihočeský"],
                    ],
                    [
                        "id" => "jihomoravsky",
                        "nazevKraje" => "Jihomoravský kraj",
                        "imgAttributes"=>["src"=>self::MAPA_IMAGES_PATH."jihomoravsky.png", "alt"=>"Jihomoravský"],
                    ],
                    [
                        "id" => "karlovarsky",
                        "nazevKraje" => "Karlovarský kraj",
                        "imgAttributes"=>["src"=>self::MAPA_IMAGES_PATH."karlovarsky.png", "alt"=>"Karlovarsky"],
                    ],
                    [
                        "id" => "kralovehradecky",
                        "nazevKraje" => "Královéhradecký kraj",
                        "imgAttributes"=>["src"=>self::MAPA_IMAGES_PATH."kralovehradecky.png", "alt"=>"Královéhradecký"],
                    ],
                    [
                        "id" => "liberecky",
                        "nazevKraje" => "Liberecký kraj",
                        "imgAttributes"=>["src"=>self::MAPA_IMAGES_PATH."liberecky.png", "alt"=>"Liberecký"],
                    ],
                    [
                        "id" => "moravskoslezsky",
                        "nazevKraje" => "Moravskoslezský kraj",
                        "imgAttributes"=>["src"=>self::MAPA_IMAGES_PATH."moravskoslezsky.png", "alt"=>"Moravskoslezský"],
                    ],
                    [
                        "id" => "olomoucky",
                        "nazevKraje" => "Olomoucký kraj",
                        "imgAttributes"=>["src"=>self::MAPA_IMAGES_PATH."olomoucky.png", "alt"=>"Olomoucký"],
                    ],
                    [
                        "id" => "pardubicky",
                        "nazevKraje" => "Pardubický kraj",
                        "imgAttributes"=>["src"=>self::MAPA_IMAGES_PATH."pardubicky.png", "alt"=>"Pardubický"],
                    ],
                    [
                        "id" => "stredocesky",
                        "nazevKraje" => "Středočeský kraj",
                        "imgAttributes"=>["src"=>self::MAPA_IMAGES_PATH."stredocesky.png", "alt"=>"Středočeský"],
                    ],
                    [
                        "id" => "ustecky",
                        "nazevKraje" => "Ústecký kraj",
                        "imgAttributes"=>["src"=>self::MAPA_IMAGES_PATH."ustecky.png", "alt"=>"Ústecký"],
                    ],
                    [
                        "id" => "vysocina",
                        "nazevKraje" => "kraj Vysočina",
                        "imgAttributes"=>["src"=>self::MAPA_IMAGES_PATH."vysocina.png", "alt"=>"Vysočina"],
                    ],
                    [
                        "id" => "zlinsky",
                        "nazevKraje" => "Zlínský kraj",
                        "imgAttributes"=>["src"=>self::MAPA_IMAGES_PATH."zlinsky.png", "alt"=>"Zlínský"],
                    ]
                ]
            ];

    public function findPodleIdKraje($idKraje) {
        if (isset($this->pracePodleIdKraje[$idKraje])) {
            return $this->pracePodleIdKraje[$idKraje];
        } else {
            throw new \UnexpectedValueException("Neznáma hodnota parametru idKraje $idKraje");
        }
    }

    public function getVyberKraje($id){
        foreach ($this->vyberKraje['seznamKraju'] as $key=>$value) {
            $optionAttributes = ["value"=>$value['id']];    // návratové hodnoty option v selectu

            if ($value['id'] == $id) {
                 $optionAttributes["selected"]=TRUE;  // selected option v selectu
                 $this->vyberKraje['seznamKraju'][$key]['imgAttributes']["class"] = "selected" ;  // class "selected" nastavena pro obrázek vybraného kraje v mapě
            }
            $this->vyberKraje['seznamKraju'][$key]["optionAttributes"] = $optionAttributes;
            $queryVariables = array_merge($this->defaultQueryVariables, ['kraj' => $this->vyberKraje['seznamKraju'][$key]["id"]]);  // přidání get proměnné kraj do getVariables                                                                                                                                       (pro odkazy v <a> tagu v mapě
            $this->vyberKraje['seznamKraju'][$key]['getVariables'] = http_build_query($queryVariables, '', '&',  PHP_QUERY_RFC3986);  // kódování query části odkazu v <a> tagu                                                                                                                                          v mapě
        }
        $this->vyberKraje['selectAttributes'] = ['name' => 'kraj'];  // atributy tagu <select> -> jméno návratové proměnné selectu
        foreach ($this->defaultQueryVariables as $key => $value) {
            $this->vyberKraje['hiddenInputs'][] = ['hiddenInputAttributes' => ["type"=>"hidden", "name"=>$key, "value"=>$value]];  //atributy pro generování tagů <input> s                                                                                                                                         hidden proměnnými ve formuláři se selectem
        }
        return $this->vyberKraje;
    }
}
