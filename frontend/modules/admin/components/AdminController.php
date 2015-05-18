<?php

namespace frontend\modules\admin\components;

use Yii;
use \yii\web\Controller;

class AdminController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['admin', 'editor'],
                    ],
                ],
            ],
        ];
    }

}