Informace pro spu�t�n� test�:

Po vytvo�en� nov� slo�ky s testy (tedy nov�ho adres��e) mus� spustit "run_composer_install.bat". Ten se nejprve pokou�� instalovat chyb�j�c� ��sti nastaven� v konfiguraci json (ty mu ��dn� nechyb�) a n�sledn� vytvo�� nov� autoloadery - nez toho nebudou spou�t�ny nov� testy.

Pro spu�t�n� test� spus� "run_phpunit_tests.bat". 
V�stupn� report z testov�n� se zapisuje do souboru "Pes/reports/phpunit_report.txt", co� je definov�no v "run_phpunit_tests.bat". Ten je vhodn� m�t otev�en� v editoru, kter� automaticky ob�erstvuje obsah - nap�. NetBeans (budou jen n�kdy upozor�ovat, �e soubor nen� v UTF-8) nebo v PSPad (ten zase upozor�uje, �e se zm�nil obsah souboru a pt� se na na�ten�). V�stupn� logy z testov�n� jsou definov�ny v phpunit.xml a jsou ukl�d�ny do "Pes/reports/testdox.txt" a "Pes/reports/testdox.html"