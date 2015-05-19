<?php

namespace frontend\modules\admin;

use Yii;
use \yii\base\Module;

class Admin extends Module
{
    public $controllerNamespace = 'frontend\modules\admin\controllers';
    public $defaultRoute = 'site';
    public $layout = "main";

    public function init()
    {
        parent::init();

        $this->setLayoutPath(__DIR__."/views/layouts");
    }

    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }

        Yii::$app->errorHandler->errorAction = "/admin/site/error";

        return true; // or false to not run the action
    }
}