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
}