<?php

require_once __DIR__.'/../init.php';

use CMSx\Container;

class ContainerTest extends PHPUnit_Framework_TestCase
{
  function testGetSet()
  {
    $c = new Container;
    $this->assertFalse($c->has('one'), 'Значения еще нет');
    $this->assertFalse($c->get('one'), 'Значение недоступно');

    $c->set('one', 123);
    $this->assertTrue($c->has('one'), 'Значение уже есть');
    $this->assertEquals(123, $c->get('one'), 'Значение = 123');

    $c->set('one', null);
    $this->assertFalse($c->has('one'), 'Значения уже нет');
    $this->assertFalse($c->get('one'), 'Значение было удалено');
  }

  function testAppendPrepend()
  {
    $c = new Container;
    $c->set('one', 'hello');

    $c->append('one', ' world');
    $this->assertEquals('hello world', $c->get('one'), 'Добавление строки в конец');

    $c->prepend('one', 'my ');
    $this->assertEquals('my hello world', $c->get('one'), 'Добавление строки в начало');

    $exp = array('one', 'two', 'three');
    $c->set('one', array('one', 'two'));
    $c->append('one', 'three');

    $this->assertEquals($exp, $c->get('one'), 'Добавление значения в конец массива');

    $c->set('one', array('two', 'three'));
    $c->prepend('one', 'one');

    $this->assertEquals($exp, $c->get('one'), 'Добавление значения в начало массива');
  }

  function testArrayAccess()
  {
    $c = new Container;
    $c->set('one', 1)
      ->set('two', 2);

    $this->assertEquals($c->get('one'), $c['one'], 'Доступ на чтение #1');
    $this->assertEquals($c->get('two'), $c['two'], 'Доступ на чтение #2');

    $this->assertTrue(isset($c['one']), 'Проверка существования элемента');

    $c['one'] = 3;
    $this->assertEquals(3, $c['one'], 'Установка значения');

    unset($c['one']);
    $this->assertFalse($c->has('one'), 'Удаление значения');

    $this->assertFalse(isset($c['one']), 'Проверка отсутствия элемента');
  }
}