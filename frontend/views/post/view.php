<?php
use \yii\bootstrap\ActiveForm;
/* @var $model frontend\models\Post */
/* @var $this yii\web\View */
$this->title = 'My Yii Application';
?>

<div class="blog-post">
    <h2 class="blog-post-title"><?=\yii\helpers\Html::encode($model->title)?></h2>
    <p class="blog-post-meta">
        <span class="pull-left"><?=date("F j, Y", $model->created_at)?> by <a href="#"><?=$model->user->username?></a></span>
        <span class="stars">
            <input class="star star-5" id="star-5" type="radio" <?php echo $model->getRating() == 5 ? 'checked="checked"' : '' ?> data-post="<?=$model->id?>" value="5" name="star" <?php echo !$model->checkRating() ? 'disabled="disabled"' : '' ?> />
            <label class="star star-5" for="star-5"></label>
            <input class="star star-4" id="star-4" type="radio" <?php echo $model->getRating() == 4 ? 'checked="checked"' : '' ?> data-post="<?=$model->id?>" value="4" name="star" <?php echo !$model->checkRating() ? 'disabled="disabled"' : '' ?> />
            <label class="star star-4" for="star-4"></label>
            <input class="star star-3" id="star-3" type="radio" <?php echo $model->getRating() == 3 ? 'checked="checked"' : '' ?> data-post="<?=$model->id?>" value="3" name="star" <?php echo !$model->checkRating() ? 'disabled="disabled"' : '' ?> />
            <label class="star star-3" for="star-3"></label>
            <input class="star star-2" id="star-2" type="radio" <?php echo $model->getRating() == 2 ? 'checked="checked"' : '' ?> data-post="<?=$model->id?>" value="2" name="star" <?php echo !$model->checkRating() ? 'disabled="disabled"' : '' ?> />
            <label class="star star-2" for="star-2"></label>
            <input class="star star-1" id="star-1" type="radio" <?php echo $model->getRating() == 1 ? 'checked="checked"' : '' ?> data-post="<?=$model->id?>" value="1" name="star" <?php echo !$model->checkRating() ? 'disabled="disabled"' : '' ?> />
            <label class="star star-1" for="star-1"></label>
        </span>
        <span class="clearfix"></span>
    </p>

    <?=$model->text?>
</div><!-- /.blog-post -->
<div class="blog-comments">
    <div class="addComment">
        <?php if(!Yii::$app->user->isGuest) { ?>
            <?php $form=ActiveForm::begin(['id' => 'addCommentForm']); ?>
                <?=$form->field($commentModel, "comment")->textarea(["rows" => 5])?>
                <div class="form-group">
                    <?=\yii\helpers\Html::submitButton("Comment", ["class" => 'btn btn-primary'])?>
                </div>
            <?php ActiveForm::end(); ?>
        <?php } else { ?>
            <div class="alert alert-warning">You must be logged in to comment. Login <a href="/site/login">here</a>.</div>
        <?php } ?>
    </div>
    <div class="comments">
        <?php if(count($comments)) { ?>
            <?php foreach($comments as $comment) { ?>
                <div class="comment" id="comment-<?=$comment->id?>">
                    <div class="author"><?=date("Y-m-d H:i:s", $comment->created_at)?> by <strong><?=$comment->user->username?></strong></div>
                    <div class="text"><?=$comment->comment?></div>
                </div>
            <?php } ?>
        <?php } ?>
    </div>
</div>