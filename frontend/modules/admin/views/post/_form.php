<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var yii\web\View $this */
/* @var yii\bootstrap\ActiveForm $form */
/* @var frontend\models\Post $model */

?>

<?php $form = ActiveForm::begin(['id' => 'post-form']); ?>
    <?=$form->field($model, 'title')?>
    <?=$form->field($model, 'text')->widget(yii\redactor\widgets\Redactor::className(), [
        'clientOptions' => [
            'plugins' => ['imagemanager', 'fontcolor'],
            'imageUpload' => ['/redactor/upload/image'],
            'fileUpload' => ['/redactor/upload/file']
        ]
    ]);?>
    <div class="form-group">
        <?=Html::submitButton(($model->isNewRecord ? 'Add' : 'Save'), ['class' => 'btn btn-primary', 'name' => 'post-button'])?>
    </div>
<?php ActiveForm::end(); ?>