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
class IpsCommand extends CConsoleCommand {

    //put your code here
    public function actionTtl() {
        $ips = Ips::model()->findAll();
        if ($ips != NULL) {
            foreach ($ips as $ip) {
                $ip->ttl--;
                $ip->save();
            }
        }
    }

}
