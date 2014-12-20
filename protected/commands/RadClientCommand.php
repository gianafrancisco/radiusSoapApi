<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RadClientCommand
 *
 * @author francisco
 */
class RadClientCommand extends CConsoleCommand {

    public function actionDisconnect($username) {
        $online = Radacct::model()->findByAttributes(array('username'=>$username), "acctstoptime is null or acctstoptime = '0000-00-00 00:00:00'");
        if ($online != NULL) {
            $nas = Nas::model()->findByAttributes(array('nasname'=>$online->nasipaddress));
            $Cmd=new RadClient($online->username,$online->acctsessionid,$online->nasipaddress,$nas->ports,$nas->secret,$nas->type);
            $Res=$Cmd->disconnect();
            Yii::log($Res,'info', 'application');
        }
    }

}
