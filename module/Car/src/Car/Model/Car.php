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
}