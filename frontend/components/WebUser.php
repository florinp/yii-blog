<?php

namespace frontend\components;

use Yii;
use yii\helpers\VarDumper;
use yii\web\HttpException;

class WebUser extends \yii\web\User
{

    public function hasRole($role)
    {
        $auth = Yii::$app->authManager;
        $userRoles = $auth->getRolesByUser($this->getId());
        //VarDumper::dump($userRoles, 10, true);

        $hasRole = false;

        if(count($userRoles)) {
            foreach($userRoles as $roleName => $roleObj) {
                if($role === $roleName || $role === $roleObj->name) {
                    $hasRole = true;
                } else {
                    continue;
                }
            }
        } else {
            return false;
        }

        return $hasRole;
    }


    public function getModel()
    {
        $model = \common\models\User::findOne([
            'id' => $this->getId()
        ]);
        if($model == null) {
            throw new HttpException(403, "Invalid request");
        }

        return $model;
    }
}