<?php
/* @var $posts frontend\models\Post[] */
/* @var $post frontend\models\Post */
/* @var $this yii\web\View */
$this->title = 'My Yii Application';

$script = <<< JS
$(document).ready(function() {
    setInterval(function(){ /*$("#refreshButton").click();*/ $.pjax.reload('#indexPjax'); console.log("refresh") }, 30000);
});
JS;

$this->registerJs($script);

?>
<?php \yii\widgets\Pjax::begin(["id" => "indexPjax"]); ?>
    <?php echo \yii\helpers\Html::a("Refresh", ["/site/index"], ["class" => 'sr-only', "id" => "refreshButton"]); ?>
    <?php if(count($posts)) { ?>
        <?php foreach($posts as $post) { ?>
            <div class="blog-post">
                <h2 class="blog-post-title"><?=\yii\helpers\Html::a(\yii\helpers\Html::encode($post->title), ["/post/view", "slug" => $post->slug])?></h2>
                <p class="blog-post-meta"><?=date("F j, Y", $post->created_at)?> by <a href="#"><?=$post->user->username?></a></p>

                <?=$post->getShortText()?>
            </div><!-- /.blog-post -->
        <?php } ?>
        <nav>
            <?php echo \yii\widgets\LinkPager::widget([
                'pagination' => $pagination,
                'options' => [
                    'tag' => 'nav',
                    'class' => 'pager'
                ],
                'nextPageLabel' => 'Next',
                'prevPageLabel' => 'Previous',
                'maxButtonCount' => 0,
                'disabledPageCssClass' => '',
                'nextPageCssClass' => '',
                'prevPageCssClass' => '',
                'linkOptions' => [
                    'tag' => 'span'
                ]
            ]); ?>
        </nav>
    <?php } else { ?>
        <div class="blog-post">
            <h2>No data found</h2>
        </div>
    <?php } ?>
<?php \yii\widgets\Pjax::end(); ?>
