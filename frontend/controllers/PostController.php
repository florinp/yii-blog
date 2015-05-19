<?php

namespace frontend\controllers;


use Yii;
use yii\data\Pagination;
use yii\helpers\VarDumper;
use yii\web\Controller;
use frontend\models\Post;
use yii\web\HttpException;

class PostController extends Controller
{

    public function actionView($slug)
    {
        $model = $this->loadModel($slug);
        return $this->render('view', [
            'model' => $model
        ]);
    }

    public function actionArchive($month, $year)
    {
        $query = Post::find();

        $firstDay = 1;
        $lastDay = 31;
        if($month%2==0) $lastDay = 30;
        if($month == 2) $lastDay = 28;

        $date1 = $firstDay."-".$month."-".$year;
        $date2 = $lastDay."-".$month."-".$year;

        $dateTime = new \DateTime();
        $date1 = $dateTime->createFromFormat("j-n-Y", $date1);
        $time1 = $date1->getTimestamp();
        $date2 = $dateTime->createFromFormat("j-n-Y", $date2);
        $time2 = $date2->getTimestamp();

        $pagination = new Pagination([
            'defaultPageSize' => 10,
            'totalCount' => $query->count()
        ]);

        $posts = $query->where("created_at >= :time1", [':time1' => $time1])
            ->andWhere("created_at <= :time2", [':time2' => $time2])
            ->orderBy("created_at DESC")
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return $this->render('archive', [
            'posts' => $posts,
            'pagination' => $pagination
        ]);

    }

    /**
     * Get the model
     * @param string $id The model id
     * @return \frontend\models\Post
     * @throws HttpException
     */
    protected function loadModel($slug)
    {
        $model = Post::findOne([
            "slug" => $slug
        ]);
        if($model == null) {
            throw new HttpException(403, "The request is invalid!");
        }

        return $model;
    }

}