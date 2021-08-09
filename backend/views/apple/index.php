<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use common\helpers\AppleHelper;
use common\widgets\Alert;

/* @var $this yii\web\View */
/* @var $searchModel common\models\AppleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Apples';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="apple-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Сгенерировать яблоки', ['generate'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php echo Alert::widget(); ?>

    <?php
        Modal::begin([
            'header'=>'<h4>Откусить от яблока</h4>',
            'id'=>'modal',
            'size'=>'modal-lg',
        ]);
        echo "<div id='modalContent'>";
        echo $this->render('_form', ['model' => new \backend\models\AppleEatForm()]);
        echo "</div>";
        Modal::end();
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            'color' => [
                    'header' => 'Цвет',
                    'format' => 'raw',
                    'value' => function($data) {
                        return "<span class='badge' style='background-color: {$data->color}'> <b>&nbsp;</b> </span>" ;
                    }
            ],
            'created_at',
            'fallen_at',
            'state' => [
                'value' => function($data) {
                    return AppleHelper::getStateText($data->state);
                }
            ],
            'size',

            ['class' => 'yii\grid\ActionColumn',
                'template' => '{fall} {eat} {delete}',
                'buttons' => [
                    'fall' => function($url, $dataProvider, $key) {
                        return Html::a('Упасть', \yii\helpers\Url::to(['apple/fall','id' => $dataProvider->id]), [
                            'class' => 'btn-update action-fall',
                            'data-pjax' => '0',]);},
                    'eat' => function($url, $dataProvider, $key) {
                        return Html::button('Откусить', ['value'=> \yii\helpers\Url::to(['apple/eat','id' => $dataProvider->id]),
                            'class' => 'btn-update action-eat',
                            'data-pjax' => '0',]);},
                    'delete' => function($url, $dataProvider, $key) {
                        return Html::a('Удалить', Url::to(['apple/delete','id' => $dataProvider->id]), [
                            'class' => 'btn-delete action-delete',
                            'data-pjax' => '0',
                            'data-confirm' => Yii::t('yii', 'Удалить это яблоко?'),
                            'data-method' => 'post',

                            ]);},
                ],
            ],
        ],
    ]); ?>


</div>

<?php

$script = "    
    jQuery(function(){
        $('button.action-eat').click(function(){
            $('#modal').modal('show')
                .find('#modalContent')
                .load($(this).attr('value'));
        });
    });";

$this->registerJs($script); ?>