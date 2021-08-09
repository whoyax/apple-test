<?php

namespace common\models;

use \appleapp\models\Apple;
/**
 * This is the ActiveQuery class for [[Apple]].
 *
 * @see Apple
 */
class AppleQuery extends \yii\db\ActiveQuery
{
    public function active()
    {
        return $this->andWhere(['state' => [Apple::STATE_ON_TREE, Apple::STATE_ON_GROUND, Apple::STATE_ROTTEN]]);
    }

    /**
     * {@inheritdoc}
     * @return Apple[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Apple|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    public function onGround()
    {
        return $this->andWhere(['state' => Apple::STATE_ON_GROUND]);
    }
}
