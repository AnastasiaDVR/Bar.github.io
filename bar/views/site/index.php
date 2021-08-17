<?php

use yii\widgets\ListView;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;

/* @var $this yii\web\View */

$this->title = 'The Bar';
?>

<div class="site-index">

    <div class="jumbotron">
        <h1>Welcome to the Bar!</h1>

        <p class="lead">How many guests are there today?</p>

        <p><a class="btn btn-lg btn-success" href="">Generate</a></p>
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-4">
                <h2>Bar</h2>

                <?=
                ListView::widget([
                    'dataProvider' => $dataProviderGuest,
                    'itemView' => '_guest',]);

                echo "<pre>";
                print_r($arrayGenre);
                echo "</pre>";          
                ?>

            </div>
            <div class="col-lg-4">
                <h2>Information</h2>
                <p> Сейчас играет: 

                <?php
                foreach ($randMusic as $value) {
                   echo $value."</br>";
                }

                // foreach ($genreMusic as $value) {
                //     echo $value."</br>";
                // }
                ?>

                </p>

            </div>
            <div class="col-lg-4">
                <h2>Dance floor</h2>

                <?=
                ListView::widget([
                    'dataProvider' => $dataProviderGuest,
                    'itemView' => '_guest',]);
                ?>

            </div>
        </div>

    </div>
</div>
