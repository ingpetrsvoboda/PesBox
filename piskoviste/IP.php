<?php

####  NEFUNKČNÍ EXPERIMENY!! ###############

/*
 * Copyright (C) 2018 pes2704
 *
 * This is no software. This is quirky text and you may do anything with it, if you like doing
 * anything with quirky texts. This text is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

// http://php.net/manual/en/function.ip2long.php#121755
function ipv4operations($ip, $mask) {
/*
     Given an IP address and Subnet Mask,
     determine the subnet address, broadcast address, and wildcard mask
     by using bitwise operators

     ref:  http://php.net/manual/en/language.operators.bitwise.php
*/

//$ip='10.10.10.7';
//$mask='255.255.255.0';
$wcmask=long2ip( ~ip2long($mask) );
$subnet=long2ip( ip2long($ip) & ip2long($mask) );
$bcast=long2ip( ip2long($ip) | ip2long($wcmask) );
echo "Given address $ip and mask $mask, \n" .
"the subnet is $subnet and broadcast is $bcast \n" .
"with a wildcard mask of $wcmask";

/*
Given address 10.10.10.7 and mask 255.255.255.0,
the subnet is 10.10.10.0 and broadcast is 10.10.10.255
with a wildcard mask of 0.0.0.255
*/

}

// http://php.net/manual/en/function.ip2long.php#82013

function ipVersion($ipAddress) {
//    Validates value as IP address, optionally only IPv4 or IPv6 or not from private or reserved ranges.
//    FILTER_FLAG_IPV4, FILTER_FLAG_IPV6, FILTER_FLAG_NO_PRIV_RANGE, FILTER_FLAG_NO_RES_RANGE
    if(filter_var($ipAddress, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) !== false) {
        $ipVersion = "v6";
    }
    else if(filter_var($ipAddress, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) !== false) {
        $ipVersion = "v4";
    }
    return $ipVersion ?? NULL;
}

// https://stackoverflow.com/questions/12435582/php-serverremote-addr-shows-ipv6
function canonicalIpV6($ipAddressV6) {
    // funkce transformuje ipV6 adresy ve tvaru, který má ekvivalent ipV4 na ipV4
    // ipV6, která nemá ipV4 ekvivalent zachová
    // ipV6, které maji ipV4 ekvivalent vznikají, pokud nějaké zařízení po cestě nebo operační systém používá vždy ipV6 socket
    // a převádí všechny adresy na ipV6 - "mapuje" ipV4 na ipV6

    // Known prefix
    $v4mapped_prefix_hex = '00000000000000000000ffff';
//    $v4mapped_prefix_bin = pack("H*", $v4mapped_prefix_hex);
    // Or more readable when using PHP >= 5.4
    $v4mapped_prefix_bin = hex2bin($v4mapped_prefix_hex);

    // Parse
    $addr = $_SERVER['REMOTE_ADDR'];
    $addr_bin = inet_pton($addr);
    if( $addr_bin === FALSE ) {
      // Unparsable? How did they connect?!?
      die('Invalid IP address');
    }

    // Check prefix
    if( substr($addr_bin, 0, strlen($v4mapped_prefix_bin)) == $v4mapped_prefix_bin) {
      // Strip prefix
      $addr_bin = substr($addr_bin, strlen($v4mapped_prefix_bin));
    }

    // Convert back to printable address in canonical form
    $addr = inet_ntop($addr_bin);
    return $addr;
}

function ipV4ToHex($ipAddress) {
    $parts = explode('.', $ipAddress);
    for($i = 0; $i < 4; $i++) {
        $parts[$i] = str_pad(dechex($parts[$i]), 2, '0', STR_PAD_LEFT);
    }
    $ipAddress = '::'.$parts[0].$parts[1].':'.$parts[2].$parts[3];
    $hex = join('', $parts);
    return $hex;
}

function ipV6ToHex($ipAddress) {
    $parts = explode(':', $ipAddress);
    // If this is mixed IPv6/IPv4, convert end to IPv6 value
    if(filter_var($parts[count($parts) - 1], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) !== false) {
        $partsV4 = explode('.', $parts[count($parts) - 1]);
        for($i = 0; $i < 4; $i++) {
            $partsV4[$i] = str_pad(dechex($partsV4[$i]), 2, '0', STR_PAD_LEFT);
        }
        $parts[count($parts) - 1] = $partsV4[0].$partsV4[1];
        $parts[] = $partsV4[2].$partsV4[3];
    }
    $numMissing = 8 - count($parts);
    $expandedParts = array();
    $expansionDone = false;
    foreach($parts as $part) {
        if(!$expansionDone && $part == '') {
            for($i = 0; $i <= $numMissing; $i++) {
                $expandedParts[] = '0000';
            }
            $expansionDone = true;
        }
        else {
            $expandedParts[] = $part;
        }
    }
    foreach($expandedParts as &$part) {
        $part = str_pad($part, 4, '0', STR_PAD_LEFT);
    }
    $ipAddress = join(':', $expandedParts);
    $hex = join('', $expandedParts);
    return $hex;
}

function ipToHex($ipAddress) {
    $hex = '';
    if(strpos($ipAddress, ',') !== false) {
        $splitIp = explode(',', $ipAddress);
        $ipAddress = trim($splitIp[0]);
    }
    $ipVersion = ipVersion($ipAddress);
    // IPv4 format
    if($ipVersion=="v4") {
        $ipAddress = ipV4ToHex($ipAddress);
    }
    // IPv6 format
    elseif ($ipVersion=="v6") {
        $ipAddress = ipV6ToHex($ipAddress);
    } else {
        user_error("Unrecognizable IP version.", E_USER_NOTICE);
        return false;
    }
    // Validate the final IP
    if(!filter_var($ipAddress, FILTER_VALIDATE_IP)) {
        return false;
    }
    return strtolower(str_pad($hex, 32, '0', STR_PAD_LEFT));
}


echo "<p>IP masking operations</p>";
$ip='10.10.10.7';
$mask='255.255.255.0';
echo "<p>".ipv4operations($ip, $mask)."</p>";

$ips = [
    "::ffff:192.000.002.123",
    "::ffff:192.0.2.123",
    "0000:0000:0000:0000:0000:ffff:c000:027b",
    "::ffff:c000:027b",
    "::ffff:c000:27b",
    "192.000.002.123",
    "192.0.2.123"
];
$finals = array();
foreach($ips as $ip) {
    $finals[] = canonicalIpV6($ip);
}
echo "<p>Canonical mapped IPV6 to IPV4</p>";
var_dump($ips);
var_dump($finals);

$ips = [
    '::192.168.0.2',
    '0:0:0:0:0:0:192.168.0.2',
    '192.168.0.2',
    '::C0A8:2',
    '0:0:0:0:0:0:C0A8:2'
];
$finals = array();
foreach($ips as $ip) {
    $finals[] = ipToHex($ip);
}
echo "<p>Convert IP to hex</p>";
var_dump($ips);
var_dump($finals);

?>
