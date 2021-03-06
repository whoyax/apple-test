<?php

namespace common\tests\unit\models;

use appleapp\models\Apple;
use appleapp\models\AppleException;



class AppleTest extends \Codeception\Test\Unit
{
    /**
     * @var \common\tests\UnitTester
     */
    protected $tester;


    /**
     * @return array
     */
    public function _fixtures()
    {
        return [
        ];
    }

    /**
     * Проверяем конструктор
     *
     * @throws \Exception
     */
    public function testCreateApple()
    {
        $model = new Apple('green');

        $this->assertEquals('green', $model->color);
        $this->assertEquals(1, $model->size);
        $this->assertEquals(Apple::STATE_ON_TREE, $model->getState());
        $this->assertNotEmpty($model->getCreatedDate());
        $this->assertEmpty($model->getFallenDate());
        var_dump($model->getCreatedDate());
    }

    /**
     * Проверяем что яблоко падает
     * Проверяем что не может упасть дважды
     *
     * @throws \Exception
     */
    public function testAppleFall()
    {
        $model = new Apple('green');
        $this->assertEquals(Apple::STATE_ON_TREE, $model->getState());

        $model->fall();
        $this->assertEquals(Apple::STATE_ON_GROUND, $model->getState());
        $this->assertNotEmpty($model->getFallenDate());

        $this->expectException(AppleException::class);
        $model->fall();
    }

    /**
     * Нельзя кусать висящее на дереве яблоко
     *
     * @throws \Exception
     */
    public function testAppleEatOnTree()
    {
        $model = new Apple('green');
        $this->assertEquals(Apple::STATE_ON_TREE, $model->getState());
        $this->expectException(AppleException::class);
        $model->eat(10);
    }


    /**
     * Проверяем, что можем есть яблоко и математику поедания
     * Проверяем, что яблоко удаляется когда съедено
     * Проверяем, что нельзя откусить от съеденного
     *
     * @throws \Exception
     */
    public function testAppleEat()
    {
        $model = new Apple('green');

        $model->fall();
        $this->assertEquals(Apple::STATE_ON_GROUND, $model->getState());
        $this->assertEquals(1, $model->size);

        $model->eat(10);
        $this->assertEquals(0.9, $model->size);
        $this->assertEquals(Apple::STATE_ON_GROUND, $model->getState());

        $model->eat(25);
        $this->assertEquals(0.65, $model->size);
        $this->assertEquals(Apple::STATE_ON_GROUND, $model->getState());

        $model->eat(65);
        $this->assertEquals(0, $model->size);
        $this->assertEquals(Apple::STATE_EATEN, $model->getState());

        $this->expectException(AppleException::class);
        $model->eat(1);

    }

    /**
     * Нельзя откусить больше 100%
     *
     * @throws \Exception
     */
    public function testAppleEatMoreThan100()
    {
        $model = new Apple('green');

        $model->fall();
        $this->assertEquals(Apple::STATE_ON_GROUND, $model->getState());
        $this->assertEquals(1, $model->size);

        $this->expectException(AppleException::class);
        $model->eat(101);
    }

    /**
     *  Нельзя откусить 0
     *
     * @throws \Exception
     */
    public function testAppleEat0()
    {
        $model = new Apple('green');

        $model->fall();
        $this->assertEquals(Apple::STATE_ON_GROUND, $model->getState());
        $this->assertEquals(1, $model->size);

        $this->expectException(AppleException::class);
        $model->eat(0);
    }

    /**
     * Нельзя прибавить к яблоку
     *
     * @throws \Exception
     */
    public function testAppleEatLessThan0()
    {
        $model = new Apple('green');

        $model->fall();
        $this->assertEquals(Apple::STATE_ON_GROUND, $model->getState());
        $this->assertEquals(1, $model->size);

        $this->expectException(AppleException::class);
        $model->eat(-1);
    }

    /**
     * Нельзя съесть больще чем осталось
     *
     * @throws \Exception
     */
    public function testAppleEatMoreThanSize()
    {
        $model = new Apple('green');

        $model->fall();
        $this->assertEquals(Apple::STATE_ON_GROUND, $model->getState());
        $this->assertEquals(1, $model->size);

        $model->eat(45);
        $this->assertEquals(0.55, $model->size);


        $this->expectException(AppleException::class);
        $model->eat(56);
    }


    /**
     * Полное съедание по умолчанию
     * Полностью съеденное яблоко меняет состояние (удаляется)
     *
     * @throws \Exception
     */
    public function testAppleEatDefault()
    {
        $model = new Apple('green');

        $model->fall();
        $this->assertEquals(Apple::STATE_ON_GROUND, $model->getState());
        $this->assertEquals(1, $model->size);

        $model->eat();
        $this->assertEquals(0, $model->size);
        $this->assertEquals(Apple::STATE_EATEN, $model->getState());
    }

    /**
     * Испорченное яблоко нельзя съесть
     *
     * @throws \Exception
     */
    public function testAppleEatRotten()
    {
        $model = new Apple('green');

        $model->fall();
        $model->spoil();

        $this->expectException(AppleException::class);
        $model->eat(56);
    }

    /**
     * Проверяем что можем испортить яблоко
     * Испорченное яблоко нельзя испортить снова
     *
     * @throws \Exception
     */
    public function testAppleSpoil()
    {
        $model = new Apple('green');

        $model->fall();
        $this->assertEquals(Apple::STATE_ON_GROUND, $model->getState());
        $this->assertEquals(1, $model->size);

        $model->spoil();
        $this->assertEquals(1, $model->size);
        $this->assertEquals(Apple::STATE_ROTTEN, $model->getState());

        $this->expectException(AppleException::class);
        $model->spoil();
    }

    /**
     * Яблоко не может испортиться на дереве
     *
     * @throws \Exception
     */
    public function testAppleSpoilOnTree()
    {
        $model = new Apple('green');

        $this->expectException(AppleException::class);
        $model->spoil();
    }

    /**
     * Целое яблоко нельзя удалить
     *
     * @throws \Exception
     */
    public function testFullAppleDelete()
    {
        $model = new Apple('green');
        $model->fall();

        $this->expectException(AppleException::class);
        $model->delete();
    }


    /**
     * Недоеденное яблоко нельзя удалить
     *
     * @throws \Exception
     */
    public function testLiveAppleDelete()
    {
        $model = new Apple('green');
        $model->fall();
        $model->eat(50);

        $this->expectException(AppleException::class);
        $model->delete();
    }


    /**
     * создание и заполнение объекта из ORM
     */
    public function testLoadFromRecord()
    {
        $time = time();
        $time2 = $time - 42;
        $record = new \common\models\Apple([
            'color' => 'green',
            'state' => Apple::STATE_ON_GROUND,
            'health' => 94,
            'created_at' => date('Y-m-d H:i:s', $time),
            'fallen_at' => date('Y-m-d H:i:s', $time2)
        ]);

        $apple = Apple::loadFromRecord($record);

        $this->assertEquals('green', $apple->color);
        $this->assertEquals(Apple::STATE_ON_GROUND, $apple->getState());
        $this->assertEquals(0.94, $apple->size);
        $this->assertEquals($time, $apple->getCreatedDate());
        $this->assertEquals($time2, $apple->getFallenDate());
    }

    /**
     *  Сохранение
     *
     * @throws \Exception
     */
    public function testSaveToRecord()
    {
        $apple = new Apple('green');
        $apple->fall();

        $record = new \common\models\Apple();
        $this->assertTrue($apple->saveToRecord($record));
        $this->assertEmpty($record->getErrors());
        $this->assertEquals('green', $record->color);
        $this->assertEquals(Apple::STATE_ON_GROUND, $record->state);
        $this->assertEquals($apple->getCreatedDate(), strtotime($record->created_at));
        $this->assertEquals($apple->getFallenDate(), strtotime($record->fallen_at));
        $this->assertEquals($apple->size * 100, $record->health);

        $record = \common\models\Apple::findOne($record->id);
        $this->assertEquals('green', $record->color);
        $this->assertEquals(Apple::STATE_ON_GROUND, $record->state);
        $this->assertEquals($apple->getCreatedDate(), strtotime($record->created_at));
        $this->assertEquals($apple->getFallenDate(), strtotime($record->fallen_at));
        $this->assertEquals($apple->size * 100, $record->health);
    }
}
