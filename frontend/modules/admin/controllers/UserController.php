<?php

namespace frontend\modules\admin\controllers;

use frontend\modules\admin\components\AdminController;
use frontend\modules\admin\models\CreateUserForm;
use Yii;
use common\models\User;
use yii\data\Pagination;
use yii\helpers\VarDumper;
use yii\web\ForbiddenHttpException;
use yii\web\HttpException;

class UserController extends AdminController
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {

        $query = User::find();

        $pagination = new Pagination([
            'defaultPageSize' => 15,
            'totalCount' => $query->count()
        ]);

        $users = $query->orderBy('created_at DESC')
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return $this->render('index', [
            'pagination' => $pagination,
            'users' => $users
        ]);
    }

    public function actionCreate()
    {
        $model = new CreateUserForm();
        $model->setScenario('create');
        if($model->load(Yii::$app->request->post())) {
            if($user = $model->create()) {
                Yii::$app->getSession()->setFlash('success', [$user->username . " was created"]);
                $this->redirect('/admin/user');
            } else {
                Yii::$app->getSession()->setFlash("error", $model->getErrors());
            }
        }

        return $this->render('create', [
            'model' => $model
        ]);
    }

    public function actionEdit($id)
    {
        $user = $this->loadModel($id);

        if($user->hasRole('admin')) {
            throw new ForbiddenHttpException("You cannot edit an administrator");
        }

        $model = new CreateUserForm();
        $model->username = $user->username;
        $model->email = $user->email;
        $model->password = '';

        if(count($user->getRoles())) {
            foreach($user->getRoles() as $roleKey => $roleValue) {
                $model->role[] = $roleKey;
            }
        }

        if(isset($_POST['CreateUserForm'])) {
            if(!empty($_POST['CreateUserForm']['password'])) {
                $model->password = $_POST['CreateUserForm']['password'];
            }
            if(!empty($_POST['CreateUserForm']['role'])) {
                $model->role = $_POST['CreateUserForm']['role'];
            }
            if($user = $model->update($user->getId())) {
                Yii::$app->getSession()->setFlash('success', [$user->username . " was updated"]);
                $this->redirect('/admin/user');
            } else {
                Yii::$app->getSession()->setFlash("error", $model->getErrors());
            }
        }

        //VarDumper::dump($model->attributes, 10, true); exit;

        return $this->render('create', [
            'model' => $model
        ]);
    }

    public function actionDelete($id)
    {
        $user = $this->loadModel($id);

        if($user->hasRole('admin')) {
            throw new ForbiddenHttpException("You cannot delete an administrator");
        }

        if($user->delete()) {
            Yii::$app->getSession()->setFlash("success", ["The data has been deleted."]);
            $this->redirect("/admin/user");
        } else {
            Yii::$app->getSession()->setFlash("error", ["An error occurred"]);
            $this->redirect("/admin/user");
        }
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