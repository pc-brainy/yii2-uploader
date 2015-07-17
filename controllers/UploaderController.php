<?php
namespace brainy\uploader\controllers;

use Yii;
use yii\web\Controller;
use yii\web\UploadedFile;
use yii\imagine\Image;
use yii\helpers\Inflector;
use yii\helpers\Json;

class UploaderController extends Controller
{
    public $file;
    public $filename;
    public $isImage;

    public function actionIndex(){
        $model = new \brainy\uploader\models\Photo();
        if (!empty($post = Yii::$app->request->post())) {
            $model = new $post['modelClass'];
            $attribute = $post['attribute'];

            $this->file = \yii\web\UploadedFile::getInstance($model, $attribute);
            $this->isImage = getimagesize($this->file->tempName);
            $this->setFilename($post);

            //prevent retry to upload  
            if($this->file == null){
                return Json::encode($model);
            }
            
            if(Json::decode($post['multiplePath']) === false) {
                if(!$this->saveToSinglePath($post)){
                   return Json::encode($model); 
                }
            }else{
                if(!$this->saveToMultiplePaths($post)){
                    return Json::encode($model); 
                }
            }
            
            //save if model is ActiveRecord
            if($model instanceof \yii\db\ActiveRecord) { 
                $this->saveDB($model, $attribute, $post);
            }
        }

        return Json::encode($model);
    }

    protected function saveDB($model, $attribute, $post){
        if(isset($post['dbFields'])){
            $dbFields = Json::decode($post['dbFields']);
        }           
        
        if($dbFields){            
            foreach($dbFields as $attr => $value){
                $model->$attr = $value;
            }
        }
        
        $model->$attribute = $this->filename;
        
        if ($model->save()) {
            return false;        
        }                
    }
    
    protected function saveToSinglePath($post){
        $pathToSave = $this->folder(). '/' .$this->filename;
        $setsize = Json::decode($post['thumbnailSize']);
        return $this->save($this->size($setsize), $pathToSave);
    }

    protected function saveToMultiplePaths($post){
        $folder = $this->folder();
        $data = Json::decode($post['multiplePath']);
        foreach($data as $lastFolder => $setsize){
            $size = $this->size($setsize);
            $pathToSave = $folder. '/' .$lastFolder.'/'.$this->filename;
            if(!$this->save($size, $pathToSave)){
                return false;
            }
        }
        return true;
    }

    protected function save($size, $pathToSave){
        if(!$this->isImage){
            return $this->file->saveAs($pathToSave);
        }else{
            return Image::thumbnail($this->file->tempName, $size[0], $size[1])->save($pathToSave);
        }
    }

    protected function size($setsize){
        //isn't image
        if(!$this->isImage){
            return false;
        }
        
        //is array, no change 
        if(is_array($setsize)){
            return $setsize;
        }
        //return original size of image file w/h
        if(!$setsize && $newsize = getimagesize($this->file->tempName)){
            return [$newsize[0], $newsize[1]];
        }
        
        return $setsize;
    }
    
    protected function folder(){
        $imgFolderPath = Yii::$app->request->post('imgFolderPath');        
        return !isset($imgFolderPath) ? Yii::getAlias('@images') : $imgFolderPath;
    }

    protected function setFilename($post){
        $ext = $this->file->getExtension();
        $filename = $post['filename'];
        $slug = $post['slug'];
        $lengthOfName = $post['lengthOfName'];
        $uniqID = isset($post['uniqid']) ? '-'.uniqid() : '';

        $name = !isset($slug)
                    ? !isset($filename) 
                            ? $this->file->name 
                            : $filename
                    : isset($filename) 
                            ? Inflector::slug($filename, '-', true) 
                            : Inflector::slug($this->file->getBaseName(), '-', true);

        $this->filename = substr($name, 0, $lengthOfName). $uniqID.'.'.$ext;
    }


}