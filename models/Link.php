<?php

namespace app\models;

use Yii;
use yii\base\Model;

class Link extends Model
{
    public static function isUnique($hash) {

        return !file_exists(Yii::getAlias('@webroot/storage/'.$hash));
    }

    public static function visit($hash) {

        $data = file_get_contents(Yii::getAlias('@webroot/storage/'.$hash));
        $data = json_decode($data, true);
        $data['visited']++;
        file_put_contents(Yii::getAlias('@webroot/storage/'.$hash), json_encode($data));
        return $data;
    }

    public static function get($hash) {

        $data = file_get_contents(Yii::getAlias('@webroot/storage/'.$hash));
        $data = json_decode($data, true);
        return $data;

    }

    public static function generate($link) {

        do {
            $hash = Yii::$app->security->generateRandomString(8);
        } while (!static::isUnique($hash));

        $data = json_encode([
            'url' => $link,
            'visited' => 0
        ]);

        file_put_contents(Yii::getAlias('@webroot/storage/'.$hash), $data);

        return $hash;
    }

}