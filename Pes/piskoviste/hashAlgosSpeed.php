<?php

// http://php.net/manual/en/function.hash.php#89574

// 7.2.0 	Usage of non-cryptographic hash functions (adler32, crc32, crc32b, fnv132, fnv1a32, fnv164, fnv1a64, joaat) was disabled.
// od 7.2. je hash_hmac, seznam algoritmů hash_hmac_algos, mezi nimi je i SHA3 - vybraný pro používání NIST - US government

echo '<pre>';

echo 'Building random data ...' . PHP_EOL;
@ob_flush();flush();

$data = '';
//for ($i = 0; $i < 64000; $i++)  // 1MB
for ($i = 0; $i < 64; $i++)  //1kB
    $data .= hash('md5', rand(), true);

echo strlen($data) . ' bytes of random data built !' . PHP_EOL . PHP_EOL . 'Testing hash algorithms ...' . PHP_EOL;
@ob_flush();flush();

$results = array();
foreach (hash_algos() as $v) {
    echo $v . PHP_EOL;
    @ob_flush();flush();
    $time = microtime(true);
    hash($v, $data, false);
    $time = microtime(true) - $time;
    $results[$time * 1000000000][] = "$v (hex)";
    $time = microtime(true);
    hash($v, $data, true);
    $time = microtime(true) - $time;
    $results[$time * 1000000000][] = "$v (raw)";
}

ksort($results);

echo PHP_EOL . PHP_EOL . 'Results: ' . PHP_EOL;

$i = 1;
foreach ($results as $k => $v)
    foreach ($v as $k1 => $v1)
        echo ' ' . str_pad($i++ . '.', 4, ' ', STR_PAD_LEFT) . '  ' . str_pad($v1, 30, ' ') . ($k / 1000) . ' microseconds' . PHP_EOL;
echo '</pre>';
?>
