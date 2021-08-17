<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Guest */

$this->title = 'Update Guest: ' . $model->id_guest;
$this->params['breadcrumbs'][] = ['label' => 'Guests', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_guest, 'url' => ['view', 'id' => $model->id_guest]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="guest-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
