<?php

namespace backend\controllers;

use Yii;
use appleapp\models\Apple;
use appleapp\models\AppleException;
use backend\models\AppleEatForm;
use common\helpers\AppleHelper;
use common\models\Apple as AppleRecord;

use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * AppleController implements the CRUD actions for Apple model.
 */
class AppleController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'generate', 'delete', 'eat', 'fall'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Apple models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => AppleRecord::find()->active(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionGenerate()
    {
        $count = mt_rand(1, 10);
        for ($i = 1; $i <= $count; $i++)
        {
            $apple = AppleHelper::generateRandomApple();
            $apple->saveToRecord(new AppleRecord());
        }

        $this->redirect('index');
    }


    public function actionEat($id)
    {
        $form = new AppleEatForm();

        if (Yii::$app->request->isAjax && $form->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($form);
        }

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $model = $this->findModel($id);
            $apple = Apple::loadFromRecord($model);

            try {
                $apple->eat($form->size) && $apple->saveToRecord($model);
            } catch (AppleException $e)
            {
                Yii::$app->session->addFlash('error', $e->getMessage());
            }
            return $this->redirect(['index']);
        }

        return $this->renderPartial('_form', [
            'model' => $form,
        ]);
    }


    public function actionFall($id)
    {
        $model = $this->findModel($id);
        $apple = Apple::loadFromRecord($model);

        try {
            $apple->fall() && $apple->saveToRecord($model);
        } catch (AppleException $e)
        {
            Yii::$app->session->addFlash('error', $e->getMessage());
        }

        return $this->redirect(['index']);
    }

    /**
     * Deletes an existing Apple model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $apple = Apple::loadFromRecord($model);

        try {
            $apple->delete() && $apple->saveToRecord($model);

        } catch (AppleException $e)
        {
            Yii::$app->session->addFlash('error', $e->getMessage());
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the Apple model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Apple the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AppleRecord::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
