<?php
use yii\bootstrap\Modal;
use kartik\file\FileInput;
use yii\helpers\Html;
use brainy\UploadController;
    
Yii::$app->h->pre($pluginOptions);

    if($modal){
        Modal::begin([
            'header'=>Yii::t('app', 'Upload files'),
            'toggleButton' => [
                'label'=>Yii::t('app', 'Upload files'), 'class'=>'btn btn-default'
            ],
        ]);
    }

    echo FileInput::widget([
        'model' => new $model[0],
        'attribute' => $model[1],
        'options' => $options,
        'pluginOptions' => $pluginOptions,
    ]);
    
    if($modal){
        Modal::end();
    }

?>