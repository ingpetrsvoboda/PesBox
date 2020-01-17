<?php switch ($mainTemplate): ?>
<?php case 'ohlasy_ctenaru': ?>
    <?= $this->insert("templates/main/ohlasy_ctenaru.php", $ohlasyCtenaru) ?>
<?php break ?>
<?php case 'kontakt': ?>
    <?= $this->insert("templates/main/kontakt.php", $kontakt) ?>
<?php break ?>
<?php case 'prac_mista': ?>
    <?= $this->insert("templates/main/prac_mista.php", $pracMista) ?>
<?php break ?>
<?php case 'pribehy': ?>
    <?= $this->insert("templates/main/pribehy_perexy.php", $pribehyPerexy) ?>
<?php break ?>
<?php case 'pribeh': ?>
    <?= $this->insert("templates/main/pribeh_a_ostatni_perexy.php", $pribehAOstatniPerexy) ?>
<?php break ?>
<?php case 'skoly_firmy': ?>
    <?= $this->insert("templates/main/skoly_firmy.php", $skolyFirmy) ?>
<?php break ?>
<?php case 'uvod': ?>
<?php default: ?>
    <?= $this->insert("templates/main/uvod.php", $uvodniStranka) ?>
<?php endswitch ?>