rem p��kaz je v uvozovk�ch, proto�e jinak konzola hl�s� neexistuj�c� p��kaz .
rem za vol�n�m phpunit ji� nen� z�dn� parametr ( ani . (te�ka)) -> pou�ije se phpunit.xml s konfigurac� testu
echo  %date%-%time%  > Pes/tests/_reports/phpunit_report.txt 
"c:\Users\pes2704\AppData\Roaming\Composer\vendor\bin\phpunit" >> Pes/tests/_reports/phpunit_report.txt 
echo > Konec
rem V�sledn� report byl zaps�n do souboru Pes/tests/_reports/phpunit_report.txt
echo "�ek�m - zav�i m�."
timeout 50
