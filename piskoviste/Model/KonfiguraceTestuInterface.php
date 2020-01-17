<?php

namespace Tester\Model;

/**
 * Z přečtené věty z db (view z db kampane_2)  poskytuje parametry testu - 
 * - zakaznik_nazev, test_nazev, test_jmeno_souboru(tj. soubor se zadanim otazek) 
 * 
 * @author vlse2610
 */
interface KonfiguraceTestuInterface {
   // public function getCustomer();
   
    public function getNazevTestu();
    public function getSadaOtazek();
    public function getPoleSpravnychOdpovedi();    
}
