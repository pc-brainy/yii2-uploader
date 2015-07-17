# Uploader
Uploader

Installation
------------
The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
composer require pc-brainy/yii2-uploader:~1.0
```
or add

```json
"pc-brainy/yii2-uploader" : "~1.0"
```

to the require section of your application's `composer.json` file.    


Configure
-----

1. Add in common/config/main.php
    'controllerMap' => [
        'uploader' => 'brainy\uploader\controllers\UploaderController',
    ],

    Yii::setAlias('storage', dirname(dirname(__DIR__)) . '/storage');
    Yii::setAlias('images', dirname(dirname(__DIR__)) . '/storage/images');

Usage
-----

with default parameters
```
<?php
    use brainy\uploader\Uploader;
    echo Uploader::widget();
?>
```

with parameters
```
<?php
    use brainy\uploader\Uploader;
    echo Uploader::widget([
        'model'=>["\brainy\uploader\models\Photo", "image"],
        'modal'=>true,
        'pluginOptions' => [
            'uploadExtraData'=>[
                    'thumbnailSize'=>[320, 200],
                    'imgFolderPath'=>Yii::getAlias('@images').'/tests',
                    'multiplePath'=>[
                        'full'=>false,
                        'middle'=>[400, 400],
                        'thumb'=>[150, 150]
                    ],      
                    'filename'=>$product->name,//product name, description, predefined string, etc
                    'slug'=>true,
                    'uniqid'=>true,

            ],
        ]
    ]);
?>
```

Parameters
----------

```
model
    ["\brainy\uploader\models\Photo", "image"] //[class, attribute]
    modelul AR in care vor fi salvate informatiile despre imagini

slug
    true/false - convert filename to slugged name
    converteste denumirea fisierului minuscule-minuscule.ext

uniqid
    true/false - add an uniq ID to filename
    adauga la numele fisierului un id unic

modal = true
    display a button to launch modal window of uploader

thumbnailSize
    not set of set false = keep actual size
    [300,200] => [width,height]px
    300 => square of 300px

uploadUrl
    set only if will be used your function to upload


multiplePath
    'multiplePath'=>[
        'folderName'=>false, //save original size
        'anotherFolderName'=>[400, 400], //save thumbnails with 400px X 400px
        'andAnotherFolderName'=>[150, 150]  //save thumbnails with 150px X 150px
        .......
    ],

filename
    a string to be used as filename for saved file

dbFields
    'dbFields'=>[
        'owner_id'=> $product->id, 
        'order'=>'999'
    ]
    pairs of informations to be saved in model in various field, along filename
    'field'=>'value'


```

