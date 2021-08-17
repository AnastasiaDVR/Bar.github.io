<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper

/* @var $this yii\web\View */
/* @var $model app\models\Guest */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="guest-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name_guest')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'genre_guest')->dropDownList(ArrayHelper::map(app\models\Genre::find()->andWhere('id_genre>0')->all(), 'id_genre', 'name_genre')) ?>

    <?= $form->field($model, 'tag_guest')->dropDownList(ArrayHelper::map(app\models\Tag::find()->andWhere('id_tag>0')->all(), 'id_tag', 'name_tag')) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
