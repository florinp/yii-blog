<?php

namespace backend\controllers;

use Yii;
use \yii\web\Controller;

class PostController extends Controller
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

    public function actionIndex()
    {

        echo "index";

    }

}