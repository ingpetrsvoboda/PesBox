<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Middleware\Api;

use Pes\Container\ContainerConfiguratorHttpAbstract;
use Psr\Container\ContainerInterface;   // pro parametr closure function(ContainerInterfaceInterface $c) {}

use Model\UvodniStranka;
use Model\NabidkaPrace;
use Model\Kraje;
use Model\SkolyFirmy;
use Model\OhlasyCtenaru;
use Model\Pribehy;
use Model\Kontakt;

/**
 * Description of MenuContainerInterfaceFactory
 *
 * @author pes2704
 */
class ContainerConfigurator extends ContainerConfiguratorHttpAbstract {

    public function getAliases() {
        ;
    }

    public function getSevicesDefinitions() {
        return [
            'pribeh' => function() {return $this->request->getQueryParams()['pribeh'] ?? '';},  // druhý parametr je default hodnota
            'kraj' => function() {return $this->request->getQueryParams()['kraj'] ?? '';},
            'layout' => function(ContainerInterface $c) {return           // $c je kontejner
                    [
                    'mainAttributes' => $c->get('mainAttributes'),
                    'main'=> [
                        'mainTemplate' => $c->get('mainTemplate'),
                        'uvodniStranka' => $c->get('uvodniStranka'),
                        'pracMista' => $c->get('pracMista'),
                        'skolyFirmy' => $c->get('skolyFirmy'),
                        'ohlasyCtenaru' => $c->get('ohlasyCtenaru'),
                        'pribehyPerexy' => $c->get('pribehyPerexy'),
                        'pribehAOstatniPerexy' => $c->get('pribehAOstatniPerexy'),
                        'kontakt' => $c->get('kontakt')
                        ]
                    ];
                },
                'mainTemplate' =>  function() { return $this->request->getQueryParams()['main'] ?? 'uvod';},  // default uvod
                'mainAttributes' => function(ContainerInterface $c) {return ['class'=>$c->get('mainTemplate')];},  // class je pojmenovaná stejně jako template
                'uvodniStranka' => function(ContainerInterface $c) {return
                        [
                        'uvodniSlovo' => $c->get('uvodniSlovo'),
                        'anotace' => $c->get('anotace'),
                        'tematickeOkruhy' => $c->get('tematickeOkruhy'),
                        'ukazka' => $c->get('ukazka'),
                        'ohlasyCtenaruUvod' => $c->get('ohlasyCtenaruUvod'),
                        'kontakt' => $c->get('kontakt'),
                        ];
                    },
                    'uvodniSlovo' => function() {return (new UvodniStranka())->getUvodniSlovo();},
                    'anotace' =>  function() {return (new UvodniStranka())->getAnotace();},
                    'tematickeOkruhy' => function() {return  (new UvodniStranka())->getTematickeOkruhy();},
                    'ukazka' => function() {return  (new UvodniStranka())->getUkazka();},
                    'ohlasyCtenaruUvod' => function() {return  (new UvodniStranka())->getOhlasy();},
                    'kontakt' => function() {return  (new Kontakt())->getKontakt();},

                'pracMista' => function(ContainerInterface $c) {return array_merge(        // v template je smíchána seznam krajů a nabídka práce ve vebraném kraji -> musím sloučit data
                            $c->get('kraje'),
                            ['nabidkaPraceVKraji' => $c->get('nabidkaPraceVKraji')]
                        );
                    },
                    'kraje' => function(ContainerInterface $c) {return (new Kraje())->getVyberKraje($c->get('kraj'));},   // parametr getVyberKraje() je selected kraj
                    'nabidkaPraceVKraji' => function(ContainerInterface $c) {
                        return (new NabidkaPrace())->findPodleIdKraje($c->get('kraj'));},

                'skolyFirmy' => function() {return (new SkolyFirmy())->getDataSkolyFirmy(); },
                'ohlasyCtenaru' => function() {return (new OhlasyCtenaru())->getOdpovedi(); },
                'pribehyPerexy' => function(ContainerInterface $c) {return ['perexy'=>$c->get('perexy')];},
                'pribehAOstatniPerexy' => function(ContainerInterface $c) {return
                        ['pribeh'=>function() use ($c) {return (new Pribehy())->getPribehStudenta($c->get('pribeh')); },
                         'perexy'=>$c->get('perexy')]; },
                    'perexy'=>function(ContainerInterface $c) {return (new Pribehy())->findPribehyPerexyOstatni($c->get('pribeh')); },
                'kontakt' => function() {return (new Kontakt())->getKontakt();},
        ];
    }

    public function getFactoriesDefinitions() {
        ;
    }
}
