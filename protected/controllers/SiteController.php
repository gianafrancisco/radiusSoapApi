<?php

class SiteController extends Controller {

    public function filters() {
        return array(
            'accessControl'
        );
    }

    public function accessRules() {
        return array(
            array('allow',
                'actions' => array('error', 'index', 'soap'),
                'ips' => array('*')),
            array('allow',
                'actions' => array('suspend', 'unsuspend', 'speedLimit'),
                'ips' => Yii::app()->params['acl']),
            array('deny',
                'ips' => array('*')
            )
        );
    }

    /**
     * Declares class-based actions.
     */
    public function actions() {
        return array(
            'soap' => array(
                'class' => 'CWebServiceAction',
            ),
        );
    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex() {
        // renders the view file 'protected/views/site/index.php'
        // using the default layout 'protected/views/layouts/main.php'
        $this->render('index');
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError() {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

    /**
     * @param string the username
     * @return bool
     * @soap
     */
    public function Suspend($username) {

        if (!$this->checkAcl(CHttpRequest::getUserHostAddress()))
            return false;

        $model = Radusergroup::model();
        $userGroups = $model->findAllByAttributes(array("username" => $username));
        $reject = false;
        $db = $user = Yii::app()->db;
        if ($userGroups == NULL) {
            return false;
        } else {
            foreach ($userGroups as $group) {
                if ($group->groupname == "REJECT") {
                    $reject = true;
                    //$group->priority = 0;
                    $db->createCommand()->update('radusergroup', array('priority' => 0), "username = '" . $group->username . "' AND groupname = '" . $group->groupname . "'");
                }
                /* else {
                  $group->priority++;
                  } */

                //$group->update();
            }
            if (!$reject) {
                /*
                  $newGroup = new Radusergroup();
                  $newGroup->username = $username;
                  $newGroup->groupname = "REJECT";
                  $newGroup->priority = 0;
                  $newGroup->save();
                 * 
                 */
                $db->createCommand()->insert('radusergroup', array('username' => $username, 'groupname' => 'REJECT', 'priority' => 0));
            }
            $commandPath = Yii::app()->getBasePath() . DIRECTORY_SEPARATOR . 'commands';
            $runner = new CConsoleCommandRunner();
            $runner->addCommands($commandPath);
            $Cmd = new RadClientCommand("RADCLIENT", $runner);
            $Cmd->actionDisconnect($username);
            return true;
        }
    }

    /**
     * @param string the username
     * @return bool
     * @soap
     */
    public function UnSuspend($username) {

        if (!$this->checkAcl(CHttpRequest::getUserHostAddress()))
            return false;

        $model = Radusergroup::model();
        $userGroups = $model->findAllByAttributes(array("username" => $username));
        $reject = false;
        $db = $user = Yii::app()->db;
        if ($userGroups == NULL) {
            return false;
        } else {
            foreach ($userGroups as $group) {
                if ($group->groupname == "REJECT") {
                    $reject = true;
                    //$group->priority = 9;
                    $db->createCommand()->update('radusergroup', array('priority' => 9), "username = '" . $group->username . "' AND groupname = '" . $group->groupname . "'");
                }
                /* else {
                  $group->priority++;
                  } */
                //$group->update();
            }
            if (!$reject) {
                /*
                  $newGroup = new Radusergroup();
                  $newGroup->username = $username;
                  $newGroup->groupname = "REJECT";
                  $newGroup->priority = 9;
                  $newGroup->save();
                 * 
                 */
                $db->createCommand()->insert('radusergroup', array('username' => $username, 'groupname' => 'REJECT', 'priority' => 9));
            }
            return true;
        }
    }

    /**
     * @param string the username
     * @param integer the uplimit
     * @param integer the downlimit
     * @return bool
     * @soap
     */
    public function SpeedLimit($username, $uplimit, $downlimit) {
        /*
         * Cisco-AVPair 
         * 
         * lcp:interface-config=rate-limit output 10485760 16000 32000 conform-action transmit exceed-action drop
         * lcp:interface-config=rate-limit input 10485760 16000 32000 conform-action transmit exceed-action drop
         * 
         * first    = $limit
         * second   = $limit / 600
         * third    = $limit / 300
         */
        if (!$this->checkAcl(CHttpRequest::getUserHostAddress()))
            return false;

        $user = Radcheck::model()->findAllByAttributes(array('username' => $username));

        if ($user == NULL) {
            return false;
        }
        if ($uplimit > 0 && $downlimit > 0) {
            $cisco_downlimit = "lcp:interface-config=rate-limit output " . $downlimit . " " . round($downlimit / 600) . " " . round($downlimit / 300) . " conform-action transmit exceed-action drop";
            $cisco_uplimit = "lcp:interface-config=rate-limit input " . $uplimit . " " . round($uplimit / 600) . " " . round($uplimit / 300) . " conform-action transmit exceed-action drop";

            $reply = Radreply::model()->findAllByAttributes(array("username" => $username, "attribute" => "Cisco-AVPair"));
            if ($reply != NULL) {
                $attrReply = $reply[0];
                $attrReply->username = $username;
                $attrReply->attribute = "Cisco-AVPair";
                $attrReply->op = ":=";
                $attrReply->value = $cisco_downlimit;
                $attrReply->update();
                $attrReply = $reply[1];
                $attrReply->username = $username;
                $attrReply->attribute = "Cisco-AVPair";
                $attrReply->op = ":=";
                $attrReply->value = $cisco_uplimit;
                $attrReply->update();
            } else {
                $attrReply = new Radreply();
                $attrReply->username = $username;
                $attrReply->attribute = "Cisco-AVPair";
                $attrReply->op = ":=";
                $attrReply->value = $cisco_downlimit;
                $attrReply->save();

                $attrReply = new Radreply();
                $attrReply->username = $username;
                $attrReply->attribute = "Cisco-AVPair";
                $attrReply->op = ":=";
                $attrReply->value = $cisco_uplimit;
                $attrReply->save();
            }
            return true;
        } else {
            return false;
        }
    }

    private function checkAcl($ip) {
        $match = false;
        foreach (Yii::app()->params['acl'] as $value) {
            if ($ip == $value || $value == '*') {
                $match = true;
            }
        }
        return $match;
    }

}
