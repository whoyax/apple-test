<?php

namespace backend\models;

use yii\base\Model;

/**
 * AppleSearch represents the model behind the search form of `common\models\Apple`.
 */
class AppleEatForm extends Model
{
    public $size;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['size'], 'integer'],
            [['size'], 'required'],
            [['size'], 'number', 'min' => 1, 'max' => 100]
        ];
    }
}
