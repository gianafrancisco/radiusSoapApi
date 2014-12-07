<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of IptablesCommand
 *
 * @author francisco
 */
class IptablesCommand extends CConsoleCommand {

    //put your code here
    public function actionAdd($ipsrc) {
        $this->actionAddIpSet($ipsrc);
        return 0;
        //echo "Run command add $ipsrc";
        /*
          $iptablesCmd = "sudo /sbin/iptables -nL Proxy";
          $iptbl_res = system($iptablesCmd, $exit_val);
          if ($exit_val) {
          return 1;
          }
          $iptablesCmd = "sudo /sbin/iptables -nL Proxy | grep '$ipsrc' | wc -l ";
          $ip = system($iptablesCmd);
          if ($ip == 0) {
          $iptablesCmd = "sudo /sbin/iptables -I Proxy -s $ipsrc -j ACCEPT && echo 'ok'";
          $res = system($iptablesCmd);
          if ($res == 'ok')
          return 0;
          else
          return 1;
          }
          return 0;
         * 
         */
    }

    public function actionDel($ipsrc) {
        $this->actionDelIpSet($ipsrc);
        return 0;
        /*
          $iptablesCmd = "sudo /sbin/iptables -nL Proxy";
          $iptbl_res = system($iptablesCmd, $exit_val);
          if ($exit_val) {
          return 1;
          }
          $iptablesCmd = "echo '$iptbl_res' | grep '$ipsrc' | wc -l";
          $ip = system($iptablesCmd);
          //$ip=strstr($iptbl_res,$ipsrc);
          if ($ip > 0) {
          $iptablesCmd = "sudo /sbin/iptables -D Proxy -s $ipsrc -j ACCEPT && echo 'ok'";
          $res = system($iptablesCmd);
          if ($res == 'ok')
          return 0;
          else
          return 1;
          }
          return 0;
         */
    }

    public function actionFlush($table = "Proxy") {
        //echo "Run command flush $table";
        $iptablesCmd = "sudo /sbin/iptables -F $table";
        echo system($iptablesCmd);
        if ($table == "Proxy") {
            $iptablesCmd = "sudo /sbin/iptables -A Proxy -s 0.0.0.0/0 -j RETURN";
            echo system($iptablesCmd);
            $iptablesCmd = "sudo /sbin/iptables -I Proxy -m set --match-set Customers src -j ACCEPT";
            echo system($iptablesCmd);
        }
    }

    public function actionShow($table = "Proxy") {
        //echo "Run command flush $table";
        $iptablesCmd = "sudo /sbin/iptables -nL $table";
        $iptbl_res = system($iptablesCmd, $exit_val);
        if ($exit_val) {
            return 1;
        }
        //$ret=system($iptablesCmd);
        return $iptbl_res;
    }

    public function actionInit() {

        $this->actionInitIpSet();
        //echo "Run command Init";
        $iptablesCmd = "sudo /sbin/iptables -F Proxy";
        echo system($iptablesCmd);
        $iptablesCmd = "sudo /sbin/iptables -N Proxy";
        echo system($iptablesCmd);
        $iptablesCmd = "sudo /sbin/iptables -A Proxy -s 0.0.0.0/0 -j RETURN";
        echo system($iptablesCmd);
        $iptablesCmd = "sudo /sbin/iptables -I Proxy -m set --match-set Customers src -j ACCEPT";
        echo system($iptablesCmd);
        $iptablesCmd = "sudo /sbin/iptables -I INPUT -p tcp -m multiport --dports 443 -j Proxy";
        echo system($iptablesCmd);
        $iptablesCmd = "sudo /sbin/iptables -I INPUT -p udp -m multiport --dports 443 -j Proxy";
        echo system($iptablesCmd);
        $iptablesCmd = "sudo /sbin/iptables -A INPUT -p tcp -m multiport --dports 443 -j DROP";
        echo system($iptablesCmd);
        $iptablesCmd = "sudo /sbin/iptables -A INPUT -p udp -m multiport --dports 443 -j DROP";
        echo system($iptablesCmd);
        return 0;
    }

    public function actionInitIpSet() {
        $Command = "sudo /usr/sbin/ipset create Customers hash:ip family inet hashsize 16384 maxelem 65536";
        exec($Command);
    }

    public function actionAddIpSet($ipsrc) {
        $Command = "sudo /usr/sbin/ipset add Customers $ipsrc 2>/dev/null";
        exec($Command);
    }

    public function actionDelIpSet($ipsrc) {
        $Command = "sudo /usr/sbin/ipset del Customers $ipsrc 2>/dev/null";
        exec($Command);
    }

}
