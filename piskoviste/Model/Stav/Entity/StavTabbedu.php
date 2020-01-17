<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Tester\Model\Stav\Entity;

/**
 * Entita StavTabbedu.
 * 
 * Má jednu public vlastnost tabbedContainer. Ta je určena k uložení serializovaného pole _Tabbed_container ukládaného do session QuickForm Tabbed kontrolérem.
 *
 * @author vlse2610
 */
class StavTabbedu extends EntityAbstract {
    public $tabbedContainer;
}
