<?php

namespace CMSx;

class Container implements \ArrayAccess
{
  protected $vars;

  /** Получить значение */
  public function get($name)
  {
    return $this->has($name)
      ? $this->vars[$name]
      : false;
  }

  /**
   * Установить значение
   * Если $value = null, значение удаляется
   */
  public function set($name, $value)
  {
    if (is_null($value)) {
      unset($this->vars[$name]);
    } else {
      $this->vars[$name] = $value;
    }

    return $this;
  }

  /** Проверка, установлено ли значение */
  public function has($name)
  {
    return isset($this->vars[$name]);
  }

  /** Добавить значение в конец строки или массива */
  public function append($name, $value)
  {
    $v = $this->get($name);
    if (is_array($v)) {
      array_push($v, $value);

      return $this->set($name, $v);
    }

    return $this->set($name, $v . $value);
  }

  /** Добавить значение в начало строки или массива */
  public function prepend($name, $value)
  {
    $v = $this->get($name);
    if (is_array($v)) {
      array_unshift($v, $value);

      return $this->set($name, $v);
    }

    return $this->set($name, $value . $this->get($name));
  }

  /** Все значения в виде массива */
  public function toArray()
  {
    return $this->vars;
  }

  /** Загрузка значений из массива. $clear - затереть существующие данные */
  public function fromArray(array $array, $clear = false)
  {
    if ($clear) {
      $this->vars = array();
    }

    foreach ($array as $key=>$val) {
      $this->set($key, $val);
    }

    return $this;
  }

  //ArrayAccess

  public function offsetExists($offset)
  {
    return $this->has($offset);
  }

  public function offsetGet($offset)
  {
    return $this->get($offset);
  }

  public function offsetSet($offset, $value)
  {
    $this->set($offset, $value);
  }

  public function offsetUnset($offset)
  {
    $this->set($offset, null);
  }
}