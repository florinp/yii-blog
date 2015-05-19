<?php
/* @var $model frontend\models\Post */
/* @var $this yii\web\View */
$this->title = 'My Yii Application';
?>

<div class="blog-post">
    <h2 class="blog-post-title"><?=\yii\helpers\Html::encode($model->title)?></h2>
    <p class="blog-post-meta"><?=date("F j, Y")?> by <a href="#"><?=$model->user->username?></a></p>

    <?=$model->text?>
</div><!-- /.blog-post -->