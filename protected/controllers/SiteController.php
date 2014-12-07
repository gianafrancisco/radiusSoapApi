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
                'actions' => array('add', 'del', 'show', 'init', 'flush'),
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
     * @param string the ipsrc
     * @return bool
     * @soap
     */
    public function Add($ipsrc) {
        if ($this->checkAcl(CHttpRequest::getUserHostAddress())) {
            $commandPath = Yii::app()->getBasePath() . DIRECTORY_SEPARATOR . 'commands';
            $runner = new CConsoleCommandRunner();
            $runner->addCommands($commandPath);
            $Cmd = new IptablesCommand("IPTABLES", $runner);
            if ($Cmd->actionAdd($ipsrc) == 0) {
                $ips = Ips::model()->findAllByAttributes(array('ip' => $ipsrc));
                if ($ips == NULL) {
                    $ip = new Ips();
                    $ip->ip = $ipsrc;
                    $ip->ttl = 1440;
                    $ip->save();
                }
                return true;
            } else {
                return false;
            }
        }
        return false;
    }

    /**
     * @param string the ipsrc
     * @return bool
     * @soap
     */
    public function Del($ipsrc) {
        if ($this->checkAcl(CHttpRequest::getUserHostAddress())) {
            $commandPath = Yii::app()->getBasePath() . DIRECTORY_SEPARATOR . 'commands';
            $runner = new CConsoleCommandRunner();
            $runner->addCommands($commandPath);
            $Cmd = new IptablesCommand("IPTABLES", $runner);

            if ($Cmd->actionDel($ipsrc) == 0) {
                $ips = Ips::model()->findAllByAttributes(array('ip' => $ipsrc));
                if ($ips != NULL) {
                    $ips[0]->delete();
                }
                return true;
            } else {
                return false;
            }
        }
        return false;
    }

    /**
     * @param string the table
     * @return string
     * @soap
     */
    public function Show($table = 'Proxy') {
        if ($this->checkAcl(CHttpRequest::getUserHostAddress())) {
            $commandPath = Yii::app()->getBasePath() . DIRECTORY_SEPARATOR . 'commands';
            $runner = new CConsoleCommandRunner();
            $runner->addCommands($commandPath);
            $Cmd = new IptablesCommand("IPTABLES", $runner);
            $Res = $Cmd->actionShow();
            if ($Res == 1) {
                return false;
            } else {
                return $Res;
            }
        }
        return false;
    }

    public function actionAdd() {
        $ipsrc = $_GET['ipsrc'];
        $ips = Ips::model()->findAllByAttributes(array('ip' => $ipsrc));
        if ($ips == NULL) {
            $ip = new Ips();
            $ip->ip = $ipsrc;
            $ip->ttl = 1440;
            $ip->save();
        }
        return true;

        $commandPath = Yii::app()->getBasePath() . DIRECTORY_SEPARATOR . 'commands';
        $runner = new CConsoleCommandRunner();
        $runner->addCommands($commandPath);
        $Cmd = new IptablesCommand("IPTABLES", $runner);
        $ipsrc = $_GET['ipsrc'];
        $Cmd->actionAdd($ipsrc);
        $this->render('index');
    }

    public function actionDel() {
        $commandPath = Yii::app()->getBasePath() . DIRECTORY_SEPARATOR . 'commands';
        $runner = new CConsoleCommandRunner();
        $runner->addCommands($commandPath);
        $Cmd = new IptablesCommand("IPTABLES", $runner);
        $ipsrc = $_GET['ipsrc'];
        $Cmd->actionDel($ipsrc);
        $this->render('index');
    }

    public function actionFlush() {
        $commandPath = Yii::app()->getBasePath() . DIRECTORY_SEPARATOR . 'commands';
        $runner = new CConsoleCommandRunner();
        $runner->addCommands($commandPath);
        $Cmd = new IptablesCommand("IPTABLES", $runner);
        $Cmd->actionFlush();
        $this->render('index');
    }

    public function actionInit() {
        $commandPath = Yii::app()->getBasePath() . DIRECTORY_SEPARATOR . 'commands';
        $runner = new CConsoleCommandRunner();
        $runner->addCommands($commandPath);
        $Cmd = new IptablesCommand("IPTABLES", $runner);
        $Cmd->actionInit();
        $this->render('index');
    }

    public function actionShow() {
        $commandPath = Yii::app()->getBasePath() . DIRECTORY_SEPARATOR . 'commands';
        $runner = new CConsoleCommandRunner();
        $runner->addCommands($commandPath);
        $Cmd = new IptablesCommand("IPTABLES", $runner);
        $Cmd->actionShow();
        $this->render('index');
    }

    public function checkAcl($ip) {
        $match = false;
        foreach (Yii::app()->params['acl'] as $value) {
            if ($ip == $value || $value == '*') {
                $match = true;
            }
        }
        return $match;
    }

}
