<?php
/* @var $posts frontend\models\Post[] */
/* @var $post frontend\models\Post */
/* @var $this yii\web\View */
$this->title = 'My Yii Application';
?>

<?php if(count($posts)) { ?>
    <?php foreach($posts as $post) { ?>
        <div class="blog-post">
            <h2 class="blog-post-title"><?=\yii\helpers\Html::a(\yii\helpers\Html::encode($post->title), ["/post/view", "slug" => $post->slug])?></h2>
            <p class="blog-post-meta"><?=date("F j, Y")?> by <a href="#"><?=$post->user->username?></a></p>

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
