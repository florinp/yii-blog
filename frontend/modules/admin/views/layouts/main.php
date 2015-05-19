<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use modules\admin\components\AdminAssets;
use frontend\widgets\Alert;

/* @var $this \yii\web\View */
/* @var $content string */

AdminAssets::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title>Yii Blog</title>
    <?php $this->head() ?>
</head>
<body>
    <?php $this->beginBody() ?>
    <?php
        NavBar::begin([
            'brandLabel' => 'Yii Blog - Dashboard',
            'brandUrl' => ['/admin'],
            'options' => [
                'class' => 'navbar-inverse navbar-fixed-top',
            ],
            'innerContainerOptions' => [
                'class' => 'container-fluid'
            ]
        ]);
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav navbar-right'],
            'items' => [
                ['label' => 'View site', 'url' => ['/site/index']],
                [
                    'label' => 'Logout (' . Yii::$app->user->identity->username . ')',
                    'url' => ['/site/logout'],
                    'linkOptions' => ['data-method' => 'post']
                ]
            ],
        ]);
        NavBar::end();
    ?>

    <div class="container-fluid">

        <div class="row">

            <div class="col-sm-3 col-md-2 sidebar">

                <?php

                    echo Nav::widget([
                        'options' => [
                            'class' => 'nav nav-sidebar'
                        ],
                        'items' => [
                            ['label' => 'Dashboard', 'url' => ['/admin']],
                        ]
                    ]);

                    echo Nav::widget([
                        'options' => [
                            'class' => 'nav nav-sidebar'
                        ],
                        'items' => [
                            ['label' => 'All posts', 'url' => ['/admin/post']],
                            ['label' => 'New post', 'url' => ['/admin/post/add']],
                        ]
                    ]);

                    if(Yii::$app->user->hasRole('admin')) {

                        echo Nav::widget([
                            'options' => [
                                'class' => 'nav nav-sidebar'
                            ],
                            'items' => [
                                ['label' => 'Users', 'url' => ['/admin/user']],
                                ['label' => 'Create user', 'url' => ['/admin/user/create']],
                            ]
                        ]);

                    }

                ?>
            </div>

        </div>

        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">

            <?= Alert::widget() ?>
            <?= $content ?>

        </div>

    </div>

    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>


