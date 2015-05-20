<?php

namespace frontend\components;

use Yii;
use yii\helpers\VarDumper;
use yii\web\HttpException;

class WebUser extends \yii\web\User
{

    /**
     * Checks if the user has a specific role
     * @param string $role role name
     * @return bool true if user has the role and false otherwise
     */
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


    /**
     * Get user model
     * @return \common\models\User
     * @throws HttpException when the model is not valid
     */
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