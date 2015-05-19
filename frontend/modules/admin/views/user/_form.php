<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var yii\web\View $this */
/* @var yii\bootstrap\ActiveForm $form */
/* @var frontend\modules\admin\models\CreateUserForm $model */

?>

<?php $form = ActiveForm::begin(['id' => 'user-form']); ?>
    <?=$form->field($model, 'username')?>
    <?=$form->field($model, 'email')?>
    <?=$form->field($model, 'password')->passwordInput()?>


    <?=$form->field($model, 'role')->listBox($model->getRoles(), ['multiple' => 'multiple'])?>
    <div class="form-group">
        <?=Html::submitButton('Save', ['class' => 'btn btn-primary', 'name' => 'post-button'])?>
    </div>
<?php ActiveForm::end(); ?>