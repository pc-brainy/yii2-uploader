<?php
namespace brainy\uploader\models;
 
use yii\db\ActiveRecord;

class Photo extends \yii\base\Model
{
    public $image;
 
    public function rules()
    {
        return [
            [['image'], 'safe'],
//            [['image'], 'file', 'extensions'=>'jpg, gif, png'],
        ];
    }
}