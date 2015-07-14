<?php

namespace brainy\controllers;

use Yii;
use yii\web\Controller;
//use yii\web\NotFoundHttpException;
//use yii\filters\VerbFilter;

/**
 * PageController implements the CRUD actions for Page model.
 */
class UploaderController extends Controller
{

    public function actionUpload(){
        Yii::$app->h->pre($_POST);
    }
    
}