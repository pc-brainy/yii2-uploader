<?php
namespace brainy\uploader;

use Yii;
use yii\bootstrap\Widget;

class Uploader extends Widget{
    
    public $var = "ceva variabila";
    
    public function run(){
        return $this->render('uploader', ['var'=>$this->var]);;
  }
  
  
}
