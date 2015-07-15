# Uploader
Image uploader

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

slug
    true/false - convert filename to slugged name

uniqid
    true/false - add an uniq ID to filename

modal = true
    display a button to launch modal window of uploader

thumbnailSize
    not set => keep actual size
    [300,200] => [width,height]px
    300 => square of 300px

uploadUrl
    set only if will be used your function to upload
```
