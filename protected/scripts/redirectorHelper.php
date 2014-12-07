#!/usr/bin/php
<?php
$temp = array();

// Extend stream timeout to 24 hours
stream_set_timeout(STDIN, 86400);
$db = connectDB();
mysql_select_db('smartdns', $db);
while ($input = fgets(STDIN)) {
    // Split the output (space delimited) from squid into an array.
    $temp = split(' ', $input);
    if (count($temp) > 2) {
        $url = $temp[0];
        //$ip = $temp[1];

        $ipfield = $temp = split('/', $temp[1]);
        $ip = $ipfield[0];

        // Set the URL from squid to a temporary holder.
        $output = $url . "\n";
        if (!backend_ip($ip)) {
            $redirect_to = get_attribute('REDIRECT_TO');
            $output = "302:" . $redirect_to . "?url=" . $url . "&ipsrc=" . $ip . "\n";
        } else {
            $ttl = get_attribute('TTL');
            update_ttl($ip, $ttl);
        }
        echo $output;
    }
}

function backend_ip($ipsrc) {
    global $db;
    //$ips = array('127.0.0.2', '192.168.1.2', '10.0.0.2');
    //$ips=array('127.0.0.1','192.168.1.2','10.0.0.2');
    $SQL = "select * from ips where ip = '$ipsrc'";
    $result = mysql_query($SQL, $db);
    $row = mysql_num_rows($result);
    //echo $row;
    /*
      while ($row = mysql_fetch_array($result)) {

      }
      foreach ($ips as $ip) {
      if (strpos($ipsrc, $ip) !== false)
      return true;
      }
     * 
     */
    if ($row > 0) // if exist the return true
        return true;
    else //if it does not exist return false
        return false;
}

function get_attribute($attribute) {
    global $db;
    $SQL = "select value from config where attribute = '" . $attribute . "'";
    $result = mysql_query($SQL, $db);
    $row = mysql_num_rows($result);
    if ($row > 0) {
        $values = mysql_fetch_array($result);
        return $values[0];
    } else {
        if ($attribute == "REDIRECT_TO") {
            return "http://127.0.0.1/";
        }
        return false;
    }
}

function update_ttl($ip, $ttl) {
    global $db;
    $SQL = "update ips set ttl = '" . $ttl . "' where ip = '" . $ip . "'";
    $result = mysql_query($SQL, $db);
}

function connectDB() {
    $db = mysql_connect('localhost', 'root', 'IsaacNewton');
    if (!$db) {
        die('No pudo conectarse: ' . mysql_error());
    }
    return $db;
}
