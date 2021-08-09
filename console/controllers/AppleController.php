<?php


namespace console\controllers;


use appleapp\models\Apple;
use appleapp\models\AppleException;
use common\models\Apple as AppleRecord;
use yii\console\Controller;
use yii\log\Logger;

class AppleController extends Controller
{
    public function actionCheckSpoil()
    {
        $models = AppleRecord::find()->moreFiveHoursOnGround()->all();
        foreach ($models as $model) {
            $apple = Apple::loadFromRecord($model);
             try {
                 $apple->spoil();
                 $apple->saveToRecord($model);

             } catch (AppleException $e) {
                 \Yii::getLogger()->log($e->getMessage(), Logger::LEVEL_ERROR, 'console_job');
                 echo $e->getMessage();
             }
        }
    }
}