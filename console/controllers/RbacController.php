<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;

class RbacController extends Controller
{

    /**
     * Creates the roles
     */
    public function actionInit()
    {
        /* @var \yii\rbac\DbManager $auth */
        $auth = Yii::$app->authManager;

        $sub = $auth->createRole("subscriber");
        $edit = $auth->createRole("editor");
        $admin = $auth->createRole("admin");

        $auth->add($sub);
        $auth->add($edit);
        $auth->add($admin);

        echo "Ok"."\n";
    }

    public function actionAssign($role, $userId = 0)
    {
        if($userId == 0) $userId = 1;

        /* @var \yii\rbac\DbManager $auth */
        $auth = Yii::$app->authManager;

        $roleClass = $auth->getRole($role);
        $auth->assign($roleClass, $userId);
        echo "Ok"."\n";
    }

    public function actionRevoke($role, $userId = 0) {
        if($userId == 0) $userId = 1;

        /* @var \yii\rbac\DbManager $auth */
        $auth = Yii::$app->authManager;

        $roleClass = $auth->getRole($role);
        $auth->revoke($roleClass, $userId);
        echo "Ok"."\n";
    }

}