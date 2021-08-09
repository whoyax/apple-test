<?php

namespace appleapp\models;


class Apple
{
    const STATE_ON_TREE = 1;
    const STATE_ON_GROUND = 2;
    const STATE_ROTTEN = 3;
    const STATE_EATEN = 4;

    /**
     * @var string Цвет
     */
    public $color;

    /**
     * @var integer Дата появления
     */
    private $_created;

    /**
     * @var integer Дата падения
     */
    private $_fallen;

    /**
     * @var int Состояние
     */
    private $_state;

    /**
     * @var int Целостность
     */
    private $_health;

    /**
     * Apple constructor.
     * @param string $color
     * @throws \Exception
     */
    public function __construct($color)
    {
        $this->color = $color;
        $this->_state = self::STATE_ON_TREE;
        $this->_health = 100;
        $this->_created = $this->_getCreatedTime();
    }

    /**
     * @return int
     */
    public function getState()
    {
        return $this->_state;
    }

    /**
     * @return integer
     */
    public function getCreatedDate()
    {
        return $this->_created;
    }

    /**
     * @return integer
     */
    public function getFallenDate()
    {
        return $this->_fallen;
    }

    /**
     * @return float
     */
    public function getSize()
    {
        return $this->_health / 100;
    }

    /**
     * Падение яблока
     *
     * @return bool
     * @throws \Exception
     */
    public function fall()
    {
        if(self::STATE_ON_TREE === $this->_state) {
            $this->_state = self::STATE_ON_GROUND;
            $this->_fallen = time();

            return true;
        }

        throw new AppleException('Это яблоко не может упасть');
    }

    /**
     * Откусить от яблока
     *
     * @param int $size
     * @return bool
     */
    public function eat($size = 100)
    {
        if(self::STATE_ON_GROUND !== $this->_state) {
            throw new AppleException('Яблоко не лежит на земле');
        }

        if($size <= 0 || $size > $this->_health) {
            throw new AppleException("Нельзя столько откусить");
        }

        $this->_health -= $size;
        if(0 === $this->_health) {
            $this->delete();
        }

        return true;
    }

    /**
     * удалить яблоко
     *
     * @return bool
     */
    public function delete()
    {
        if(0 !== $this->_health) {
            throw new AppleException('Нельзя удалить недоеденное яблоко');
        }

        $this->_state = self::STATE_EATEN;

        return true;
    }

    /**
     * испортить яблоко
     *
     * @return bool
     */
    public function spoil()
    {
        if(self::STATE_ON_GROUND === $this->_state) {
            $this->_state = self::STATE_ROTTEN;
            return true;
        }

        throw new AppleException("Это яблоко не может испортиться");
    }

    /**
     * getters magic
     *
     * @param $name
     * @return mixed
     * @throws AppleException
     */
    public function __get($name)
    {
        $getter = 'get' . $name;
        if (method_exists($this, $getter)) {
            return $this->$getter();
        }

        throw new AppleException('Getting unknown property: ' . get_class($this) . '::' . $name);
    }

    /**
     * @return int
     */
    protected function _getCreatedTime()
    {
        $randomTime = (time() - mt_rand(0, 60*60*24*7)); // случайно в пределах недели
        return $randomTime;
    }

}