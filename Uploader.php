<?php
namespace brainy\uploader;

use Yii;
use yii\bootstrap\Widget;
use yii\helpers\Url;

class Uploader extends Widget{
    //default
    public $modal = false;
    public $model;

    public $uploadUrl;
    public $thumbnailSize;
    public $imgFolderPath;
   
    public $options;
    public $pluginOptions;
    
    public function init(){
        parent::init();
        $this->model = isset($this->model) ? $this->model : ["\brainy\uploader\models\Photo", "image"];
        $this->setPluginOptions();
    }

    protected function setPluginOptions(){
        $this->pluginOptions['uploadUrl'] = isset($this->pluginOptions['uploadUrl']) ? $this->pluginOptions['uploadUrl'] : Url::to(['/uploader']);
        $this->pluginOptions['uploadExtraData'] = $this->extraData();
    }

    protected function extraData(){
        $extraData = isset($this->pluginOptions['uploadExtraData'])?$this->pluginOptions['uploadExtraData'] : [];
        $extraData['model'] = $this->model;
        return $extraData;
    }
    
    public function getPathToImage(){
        return $this->imgFolderPath ? $this->imgFolderPath : Yii::getAlias('@baseUrlImages');
    }
    
    public function run(){
        return $this->render('uploader', [
            'model'=>$this->model,
            'modal'=>$this->modal,
            'options'=>$this->options,
            'pluginOptions'=>$this->pluginOptions,
        ]);
    }
  
  
}
