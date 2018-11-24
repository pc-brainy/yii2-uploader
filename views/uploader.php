<?php
use yii\bootstrap\Modal;
use kartik\file\FileInput;
use yii\helpers\Html;
use brainy\UploadController;

    if($modal){
        Modal::begin([
            'header'=>Yii::t('app', 'Upload files'),
            'toggleButton' => [
                'label'=>Yii::t('app', 'Upload files'), 'class'=>'btn btn-default'
            ],
        ]);
    }

    echo FileInput::widget([
        'model' => $model,
        'attribute' => $attribute,
        'options' => $options,
        'pluginOptions' => $pluginOptions,
        'pluginEvents' => $pluginEvents,
    ]);

    if($modal){
        Modal::end();
    }

?>