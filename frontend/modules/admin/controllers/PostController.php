<?php

namespace frontend\modules\admin\controllers;

use frontend\models\Post;
use frontend\widgets\Alert;
use Yii;
use frontend\modules\admin\components\AdminController;
use yii\data\Pagination;
use yii\helpers\VarDumper;
use yii\web\HttpException;

class PostController extends AdminController
{
    public function actionIndex()
    {
        $query = Post::find();

        $pagination = new Pagination([
            'defaultPageSize' => 15,
            'totalCount' => $query->count()
        ]);

        $posts = $query->orderBy('created_at')
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return $this->render('index', [
            'pagination' => $pagination,
            'posts' => $posts
        ]);
    }

    public function actionAdd()
    {
        $model = new Post();
        if(isset($_POST['Post'])) {
            $postValue = $_POST['Post'];
            $attrs = [];
            $attrs['userId'] = Yii::$app->user->getId();
            $attrs['title'] = $postValue['title'];
            $attrs['slug'] = self::slugify($postValue['title']);
            $attrs['text'] = $postValue['text'];

            $model->attributes = $attrs;

            if($model->save()) {
                Yii::$app->getSession()->setFlash("success", ["The data has been saved."]);
                $this->redirect("/admin/post");
            } else {
                Yii::$app->getSession()->setFlash("error", ["An error occurred"]);
            }
        }

        return $this->render('addPost', [
            'model' => $model
        ]);
    }

    public function actionEdit($id)
    {
        $model = $this->loadModel($id);
        if(isset($_POST['Post'])) {
            $postValue = $_POST['Post'];
            $model->attributes = $postValue;
            if($model->save()) {
                Yii::$app->getSession()->setFlash("success", ["The data has been saved."]);
                //$this->refresh();
            } else {
                Yii::$app->getSession()->setFlash("error", ["An error occurred"]);
            }
        }
        return $this->render('editPost', [
            'model' => $model
        ]);
    }

    public function actionDelete($id)
    {
        $model = $this->loadModel($id);
        if($model->delete()) {
            Yii::$app->getSession()->setFlash("success", ["The data has been deleted."]);
            $this->redirect("/admin/post");
        } else {
            Yii::$app->getSession()->setFlash("error", ["An error occurred"]);
            $this->redirect("/admin/post");
        }
    }

    protected static function slugify($text)
    {
        $text = preg_replace('~[^\\pL\d]+~u', '-', $text);
        $text = trim($text, '-');
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        $text = strtolower($text);
        $text = preg_replace('~[^-\w]+~', '', $text);
        if (empty($text)) {
            return 'n-a';
        }

        $postsCount = Post::find()
            ->where("slug = :slug", [':slug' => $text])
            ->count();

        if($postsCount > 0) {
            $text = $text . '-' . ($postsCount + 1);
        }

        return $text;
    }

    /**
     * Get the model
     * @param string $id The model id
     * @return \frontend\models\Post
     * @throws HttpException
     */
    protected function loadModel($id)
    {
        $model = Post::findOne([
            "id" => $id
        ]);
        if($model == null) {
            throw new HttpException(403, "The request is invalid!");
        }

        return $model;
    }

}