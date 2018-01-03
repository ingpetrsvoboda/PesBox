Informace pro spuštění testů:

Po vytvoření nové složky s testy (tedy nového adresáře) musí spustit "run_composer_install.bat". Ten se nejprve pokouší instalovat chybějící části nastavené 
v konfiguraci json a následně vytvoří nové autoloadery - bez toho nebudou spouštěny nové testy.

Pro spuštění testů mimo Netbeans lze spustit "run_phpunit_tests.bat". 
Výstupní report z testování se zapisuje do souboru "Pes/reports/phpunit_report.txt", což je definováno v "run_phpunit_tests.bat". 
Výstupní logy z testování jsou definov�ny v phpunit.xml - nyní jsou jsou ukládány do "Pes/reports/testdox.txt" a "Pes/reports/testdox.html" ve formátu testdox.