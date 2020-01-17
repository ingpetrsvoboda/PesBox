rem pý¡kaz je v uvozovk ch, proto§e jinak konzola hl s¡ neexistuj¡c¡ pý¡kaz .
rem za vol n¡m phpunit ji§ nen¡ z dnì parametr ( ani . (teŸka)) -> pou§ije se phpunit.xml s konfigurac¡ testu
echo  %date%-%time%  > Pes/tests/_reports/phpunit_report.txt 
"c:\Users\pes2704\AppData\Roaming\Composer\vendor\bin\phpunit" >> Pes/tests/_reports/phpunit_report.txt 
echo > Konec
rem Vìslednì report byl zaps n do souboru Pes/tests/_reports/phpunit_report.txt
echo "¬ek m - zavýi mØ."
timeout 50
