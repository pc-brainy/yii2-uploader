<?php
namespace brainy\uploader\models;
 
use yii\db\ActiveRecord;

class Photo extends ActiveRecord
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