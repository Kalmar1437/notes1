<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<?php $form = ActiveForm::begin([ 'method'=>'post']); ?>

    <?= $form->field($model, 'username') ?>

    <?= $form->field($model, 'email') ?>
    
    <?= $form->field($model, 'password')->passwordInput() ?>
    

    <div class="form-group">
        <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end(); ?>