<?php

namespace frontend\modules\admin\models;

use common\models\User;
use yii\base\Model;
use Yii;
use yii\helpers\VarDumper;
use yii\web\HttpException;

class CreateUserForm extends Model
{

    public $username;
    public $email;
    public $password;
    public $role;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.', 'on' => 'create'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.', 'on' => 'create'],

            ['password', 'required', 'on' => 'create'],
            ['password', 'string', 'min' => 6],
        ];
    }

    public function create()
    {

        if($this->validate()) {
            $user = new User();
            $user->username = $this->username;
            $user->email = $this->email;
            $user->setPassword($this->password);
            $user->generateAuthKey();
            if($user->save()) {
                $auth = Yii::$app->authManager;
                if(is_array($this->role) && count($this->role)) {
                    foreach($this->role as $roleName) {
                        $role = $auth->getRole($roleName);
                        $auth->assign($role, $user->getId());
                    }
                } elseif(trim($this->role) != '') {
                    $role = $auth->getRole($this->role);
                    $auth->assign($role, $user->getId());
                } else {
                    $role = $auth->getRole('subscriber');
                    $auth->assign($role, $user->getId());
                }

                return $user;
            }
        }

        return null;
    }

    public function update($id)
    {
        if($this->validate()) {
            $user = $this->loadModel($id);
            $user->username = $this->username;
            $user->email = $this->email;
            if($this->password != null || trim($this->password) != '') {
                $user->setPassword($this->password);
            }
            if($user->save()) {
                $auth = Yii::$app->authManager;
                $auth->revokeAll($user->getId());

                if(is_array($this->role) && count($this->role)) {
                    foreach($this->role as $roleName) {
                        $role = $auth->getRole($roleName);
                        $auth->assign($role, $user->getId());
                    }
                } elseif(trim($this->role) != '') {
                    $role = $auth->getRole($this->role);
                    $auth->assign($role, $user->getId());
                } else {
                    $role = $auth->getRole('subscriber');
                    $auth->assign($role, $user->getId());
                }

                return $user;
            }
        }

        return null;
    }

    public function getErrors()
    {
        $getErrors = parent::getErrors();
        $errors = [];

        foreach($getErrors as $attr => $attrErrors) {
            foreach($attrErrors as $errorMsg) {
                $errors[] = $errorMsg;
            }
        }

        return $errors;
    }

    public function getRoles()
    {
        $auth = Yii::$app->authManager;
        $roles = [];
        foreach($auth->getRoles() as $role) {
            $roles[$role->name] = strtoupper($role->name);
        }

        return $roles;
    }

    /**
     * Get the model
     * @param string $id The model id
     * @return \common\models\User
     * @throws HttpException
     */
    protected function loadModel($id)
    {
        $model = User::findOne([
            "id" => $id
        ]);
        if($model == null) {
            throw new HttpException(403, "The request is invalid!");
        }

        return $model;
    }
}