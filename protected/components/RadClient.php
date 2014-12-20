<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RadClient
 *
 * @author francisco
 */
class RadClient {

    //put your code here
    private $username = "";
    private $sessionId = "";
    private $nasIpaddress = "";
    private $nasPort = "";
    private $nasSecret = "";
    private $nasType = "";
    private $radClientCmd = "/home/francisco/freeradius-2.2.4/bin/radclient";

    function RadClient($username, $sessionId, $nasIpaddress, $nasPort, $nasSecret, $nasType) {
        $this->username = $username;
        $this->nasIpaddress = $nasIpaddress;
        $this->nasPort = $nasPort;
        $this->sessionId = $sessionId;
        $this->nasSecret = $nasSecret;
        $this->nasType = $nasType;
    }

    function disconnect() {
        $Command="";
        if ($this->nasType == "cisco") {
            $Command = 'echo "Acct-Session-Id=' . $this->sessionId . '" | ' . $this->radClientCmd . ' -4 -n 1 -s ' . $this->nasIpaddress . ':' . $this->nasPort . ' disconnect ' . $this->nasSecret;
        } else {
            $Command = 'echo "User-Name=' . $this->username . ',Acct-Session-Id=' . $this->sessionId . '" | ' . $this->radClientCmd . ' -4 -n 1 -s ' . $this->nasIpaddress . ':' . $this->nasPort . ' disconnect ' . $this->nasSecret;
        }
        exec($Command);
        return $Command;
    }

}
