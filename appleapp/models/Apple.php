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
     * @var \DateTime Дата появления
     */
    private $_created;

    /**
     * @var \DateTime Дата падения
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
     * @param $color
     * @throws \Exception
     */
    public function __construct($color)
    {
        $this->color = $color;
        $this->_state = self::STATE_ON_TREE;
        $this->_health = 100;
        $this->_created = $this->_getCreatedTime();
    }

}