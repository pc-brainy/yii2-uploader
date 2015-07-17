<?php
namespace brainy\uploader;

use Yii;
use yii\bootstrap\Widget;
use yii\helpers\Url;
use yii\helpers\Json;

class Uploader extends Widget{
    //default
    public $modal = false;
    public $model;
    public $attribute;

    public $uploadUrl;
    public $thumbnailSize;
    public $imgFolderPath;
   
    public $options;
    public $pluginOptions;
    public $lengthOfName = 237;
        
    public function init(){
        parent::init();
        $this->model = isset($this->model) ? $this->model : new \brainy\uploader\models\Photo;
        $this->attribute = isset($this->attribute) ? $this->attribute : "image";
        $this->setPluginOptions();
    }

    protected function setPluginOptions(){
        $this->pluginOptions['uploadUrl'] = isset($this->pluginOptions['uploadUrl']) ? $this->pluginOptions['uploadUrl'] : Url::to(['/uploader']);
        $this->pluginOptions['uploadExtraData'] = $this->extraData();
    }

    protected function extraData(){
        $pluginExtra = $this->pluginOptions['uploadExtraData'];

        $extraData = isset($pluginExtra) ? $pluginExtra : [];
        $extraData['modelClass'] = get_class($this->model);
        $extraData['attribute'] = $this->attribute;
        
        $extraData['multiplePath'] = isset($pluginExtra['multiplePath']) ? Json::encode($pluginExtra['multiplePath']) : false;
        $extraData['thumbnailSize'] = isset($pluginExtra['thumbnailSize']) ? Json::encode($pluginExtra['thumbnailSize']) : false;
        $extraData['dbFields'] = isset($pluginExtra['dbFields']) ? Json::encode($pluginExtra['dbFields']) : false;
        $extraData['lengthOfName'] = isset($pluginExtra['lengthOfName']) ? $pluginExtra['lengthOfName'] : $this->lengthOfName;
        
        
        return $extraData;
    }
    
    public function getPathToImage(){
        return $this->imgFolderPath ? $this->imgFolderPath : Yii::getAlias('@baseUrlImages');
    }
    
    public function run(){
        return $this->render('uploader', [
            'model'=>$this->model,
            'attribute'=>$this->attribute,            
            'modal'=>$this->modal,
            'options'=>$this->options,
            'pluginOptions'=>$this->pluginOptions,
        ]);
    }
  
  
}
