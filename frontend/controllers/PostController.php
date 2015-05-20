<?php

namespace frontend\controllers;


use frontend\models\Comment;
use frontend\models\Rating;
use Yii;
use yii\data\Pagination;
use yii\helpers\VarDumper;
use yii\web\Controller;
use frontend\models\Post;
use yii\web\ForbiddenHttpException;
use yii\web\HttpException;

class PostController extends Controller
{

    public function actionView($slug)
    {
        $model = $this->loadModel($slug);
        $commentModel = new Comment();

        $comments = $model->comments;

        if(isset($_POST['Comment'])) {
            $attrs = [];
            $attrs['postId'] = $model->id;
            $attrs['userId'] = Yii::$app->user->getId();
            $attrs['comment'] = nl2br($_POST['Comment']['comment']);

            $commentModel->attributes = $attrs;

            //VarDumper::dump($commentModel->attributes, 10, true); exit;

            if($commentModel->save()) {
                $this->refresh("#comment-".$commentModel->id);
            }
        }

        return $this->render('view', [
            'model' => $model,
            'commentModel' => $commentModel,
            'comments' => $comments
        ]);
    }

    public function actionArchive($month, $year)
    {
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

        $query = Post::find()->where("created_at >= :time1", [':time1' => $time1])
            ->andWhere("created_at <= :time2", [':time2' => $time2]);

        $pagination = new Pagination([
            'defaultPageSize' => 10,
            'totalCount' => $query->count()
        ]);

        $posts = $query->orderBy("created_at DESC")
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return $this->render('archive', [
            'posts' => $posts,
            'pagination' => $pagination
        ]);

    }

    public function actionRate()
    {
        if(Yii::$app->request->isAjax) {
            Yii::$app->response->format = 'json';
            if(!Yii::$app->user->isGuest) {
                $model = new Rating();
                $model->attributes = [
                    'postId' => $_POST['postId'],
                    'userId' => Yii::$app->user->getId(),
                    'rating' => $_POST['rating']
                ];

                if($model->save()) {
                    return [
                        'success' => true,
                        'rating' => [
                            'id' => $model->id,
                            'totalRating' => $model->post->getRating()
                        ]
                    ];
                } else {
                    return [
                        'success' => false,
                        'errors' => $model->getErrors()
                    ];
                }

            } else {
                throw new ForbiddenHttpException("No access");
            }

        } else {
            throw new HttpException(403, "The request is invalid");
        }
    }

    /**
     * Get the model
     * @param string $slug The model id
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