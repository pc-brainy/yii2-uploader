<?php

namespace brainy\uploader\controllers;

use Yii;
use yii\web\Controller;
use yii\web\UploadedFile;
use yii\imagine\Image;
use yii\helpers\Inflector;

class UploaderController extends Controller
{
    public function actionIndex(){

        $model = new \brainy\uploader\models\Photo();
        if (!empty($post = Yii::$app->request->post())) {
//          Yii::$app->h->dump($post);

            $dataModel = explode(',', $post['model']);
            $model = new $dataModel[0];

            $file = \yii\web\UploadedFile::getInstance($model, $dataModel[1]);
            
            //prevent retry to upload
            if($file == null){
                return \yii\helpers\Json::encode($model);
            }
            
            $pathToSave = $this->folder(). '/' .$this->name($file);
            $size = $this->size();

            //is set thumbnail size && is image
            if($size && getimagesize($file->tempName)){
                if(!Image::thumbnail($file->tempName, $size[0], $size[1])->save($pathToSave)){
                    return \yii\helpers\Json::encode($model);
                }
            }

            //full size
            if(!$file->saveAs($pathToSave)){
                return \yii\helpers\Json::encode($model);
            }
        }

        return \yii\helpers\Json::encode($model);
    }

    public function size(){
        $post = Yii::$app->request->post('thumbnailSize');
        if($post==0){
            return false;
        }

        $p = explode(',', $post);
        $width = $p[0];
        $height = count($p) == 2 ? $p[1] : $p[0];

        return [$width, $height];
    }

    public function folder(){
        $post = Yii::$app->request->post();
        if(!isset($post['imgFolderPath'])){
            return Yii::getAlias('@images');
        }

        return $post['imgFolderPath'];
    }

    public function name($file){
        $post = Yii::$app->request->post();
        if(!isset($post['slug'])){
            return $file->name;
        }

        $lengthOfName = 237;
        
        $uniqID = isset($post['uniqid']) ? '-'.uniqid() : '';
        $name = Inflector::slug($file->getBaseName(), '-', true);
        
        return substr($name, 0, $lengthOfName). $uniqID.'.'.$file->getExtension();
    }


//    public function name($name){
//        #237 = 255-18 (14(-uniquid) -4(.ext))
//        $lengthOfName = 237;
//        # Prep string with some basic normalization
//        # Remove quotes (can't, etc.)
//        $oneString = str_replace('\'', '', html_entity_decode(stripslashes(strip_tags(strtolower($name)))));
//        # Replace non-alpha numeric with hyphens
//        $match = '/[^a-z0-9]+/';
//        $replace = '-';
//        return substr(trim(preg_replace($match, $replace, $oneString), '-'),0, $lengthOfName).'-'. uniqid().'.jpg';
//    }



}