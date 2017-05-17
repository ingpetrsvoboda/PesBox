Informace pro spuštìní testù:

Po vytvoøení nové sloky s testy (tedy nového adresáøe) musíš spustit "run_composer_install.bat". Ten se nejprve pokouší instalovat chybìjící èásti nastavené v konfiguraci json (ty mu ádné nechybí) a následnì vytvoøí novì autoloadery - nez toho nebudou spouštìny nové testy.

Pro spuštìní testù spus "run_phpunit_tests.bat". 
Vıstupní report z testování se zapisuje do souboru "Pes/reports/phpunit_report.txt", co je definováno v "run_phpunit_tests.bat". Ten je vhodné mít otevøenı v editoru, kterı automaticky obèerstvuje obsah - napø. NetBeans (budou jen nìkdy upozoròovat, e soubor není v UTF-8) nebo v PSPad (ten zase upozoròuje, e se zmìnil obsah souboru a ptá se na naètení). Vıstupní logy z testování jsou definovány v phpunit.xml a jsou ukládány do "Pes/reports/testdox.txt" a "Pes/reports/testdox.html"