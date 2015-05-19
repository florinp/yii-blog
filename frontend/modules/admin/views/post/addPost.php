<?php

/* @var yii\web\View $this */
/* @var frontend\models\Post $model */

?>

<h1 class="page-header">Add new post</h1>

<div class="row col-md-8">

    <div class="panel panel-default">
        <div class="panel-body">
            <?php echo $this->render('_form', ['model' => $model]); ?>
        </div>
    </div>

</div>