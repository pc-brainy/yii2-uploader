<?php
    use yii\helpers\Url;
    use kartik\file\FileInput;
    use yii\helpers\Html;
    use brainy\UploadController;

?>

        <?php
            echo '<label class="control-label">Adauga imagini</label>';
            echo FileInput::widget([
                'name'=>'imagine',
//                'model' => $model,
                'attribute' => 'imagine',
                'options' => ['multiple' => true],
                 'pluginOptions' => [
                    'uploadUrl' => Url::to(['upload']),
//                    'uploadExtraData' => [
//                            'produs' => $produs->id,
//                            'numeProdus' => $produs->nume
//                        ],
                    'maxFileCount' => 10
                ]
            ]);
        ?>