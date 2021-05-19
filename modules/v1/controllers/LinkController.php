<?php

namespace app\modules\v1\controllers;

use app\models\Link;
use Yii;
use yii\filters\VerbFilter;
use yii\rest\Controller;

class LinkController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'create' => ['post', 'options'],
                    'get' => ['get', 'options']
                ]
            ]
        ];
    }

    public function actionCreate()
    {
        Yii::$app->response->format = Yii::$app->response::FORMAT_JSON;
        $url = Yii::$app->request->post('url', null);
        if ($url) {
            $hash = Link::generate($url);
            return $this->asJson(Yii::$app->request->hostInfo .'/'. $hash);
        }
    }

    public function actionGet($hash)
    {
        Yii::$app->response->format = Yii::$app->response::FORMAT_JSON;
        $data = Link::get($hash);
        return  $this->asJson($data);
    }
}