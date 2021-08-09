<?php
namespace common\models;

use Yii;
use yii\base\BaseObject;
use yii\base\NotSupportedException;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 *
 */

class SimpleAuthUser extends BaseObject implements IdentityInterface
{
    private static $_id = 'test';
    private static $_login = 'test';
    private static $_authkey = 'test';
    private static $_password = 'test';


    /**
     * @param string $name
     * @return SimpleAuthUser|null
     */
    public static function getDefaultIdentity()
    {
        return new self();
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        if( static::$_id === $id )
        {
            return new self();
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return static::$_id;
    }

    /**
     * {@inheritdoc}
     */
    public function getUsername()
    {
        return static::$_login;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return static::$_authkey;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return ( static::$_password === $password );
    }
}
