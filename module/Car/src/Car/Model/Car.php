<?php

namespace Car\Model;

class Car
{
	/**
	 * Уникальный ID авто
	 *
	 * @var int
	 */
	public $id;

	/**
	 * Марка авто
	 *
	 * @var string
	 */
	public $brand;

	/**
	 * Модель авто
	 *
	 * @var string
	 */
	public $model;

	/**
	 * Комплектация авто
	 *
	 * @var string
	 */
	public $config;

	/**
	 * Мощность в л.с
	 *
	 * @var int
	 */
	public $power;

	/**
	 * Цвет авто
	 *
	 * @var string
	 */
	public $color;

	/**
	 * Изображение
	 *
	 * @var string
	 */
	public $image;

	/**
	 * Цена авто в рублях
	 *
	 * @var int
	 */
	public $price;

	/**
	 * Статус авто
	 *
	 * @var int
	 */
	public $status;

	/**
	 * Статусы авто
	 */
	const STATUS_FREE = 1;
	const STATUS_RESERVED = 2;
	const STATUS_SOLD = 3;

	/**
	 * Метод заполнения полей модели
	 *
	 * @param $data
	 */
	public function exchangeArray($data)
	{
		foreach ($this->toArray() as $property => $value)
		{
			$this->{$property} = (!empty($data[$property])) ? $data[$property] : null;
		}
	}

	/**
	 * Возвращает представление модели в виде массива
	 *
	 * @return array
	 */
	public function toArray()
	{
		$array = [];
		$ref = new \ReflectionClass($this);

		foreach ($ref->getProperties(\ReflectionProperty::IS_PUBLIC) as $property)
		{
			$array[$property->name] = $this->{$property->name};
		}

		return $array;
	}

	/**
	 * Получаем список констант класса
	 *
	 * @param string $prefix фильтр по префиксу
	 *
	 * @return array
	 */
	public static function getConstants($prefix = null)
	{
		$reflect = new \ReflectionClass(static::class);
		$constants =  $reflect->getConstants();

		if (!is_null($prefix))
		{
			foreach ($constants as $name => $value)
			{
				if (strpos($name, $prefix) !== 0)
				{
					unset($constants[$name]);
				}
			}
		}

		return $constants;
	}
}