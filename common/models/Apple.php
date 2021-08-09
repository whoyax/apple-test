<?php

namespace common\models;


/**
 * This is the model class for table "apple".
 *
 * @property int $id
 * @property string $color
 * @property string $created_at
 * @property string|null $fallen_at
 * @property int $state
 * @property int $health
 */
class Apple extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'apple';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        // TODO
        return [
            [['color', 'created_at', 'state'], 'required'],
            [['created_at', 'fallen_at'], 'safe'],
            [['state', 'health'], 'integer'],
            [['color'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'color' => 'Цвет',
            'created_at' => 'Создано',
            'fallen_at' => 'Упало',
            'state' => 'Состояние',
            'size' => 'Целостность',
        ];
    }

    public function getSize()
    {
        return $this->health/100;
    }

    /**
     * {@inheritdoc}
     * @return AppleQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AppleQuery(get_called_class());
    }
}
