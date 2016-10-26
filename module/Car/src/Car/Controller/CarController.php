<?php

namespace Car\Controller;

use Car\Model\Car;
use Car\Model\CarTable;
use Faker\Factory as FakerFactory;
use Zend\Db\Adapter\Exception\InvalidQueryException;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;

class CarController extends AbstractActionController
{
	protected $carTable;

	/**
	 * Получаем список авто
	 *
	 * @return JsonModel
	 */
	public function listAction()
	{
		$success = true;

		try{
			$cars = $this->getCarTable()->fetchAll();
		}
		catch (InvalidQueryException $e){
			$success = false;
		}

		$result = [
			'success' => $success,
			'cars' => !empty($cars) ? $cars->toArray(): [],
		];

		return new JsonModel($result, ['prettyPrint' => true]);
	}

	/**
	 * Метод получения объекта таблицы авто
	 *
	 * @return CarTable
	 */
	public function getCarTable()
	{
		if (!$this->carTable) {
			$sm = $this->getServiceLocator();
			$this->carTable = $sm->get('Car\Model\CarTable');
		}

		return $this->carTable;
	}

	/**
	 * Метод генерации списка авто
	 *
	 * @return JsonModel
	 */
	public function generateAction()
	{
		$this->getCarTable()->create();

		$faker = FakerFactory::create();

		for ($i = 1; $i < 30; $i++)
		{
			$car = new Car();

			$car->exchangeArray([
				'brand' => $faker->randomElement(['bmw', 'subaru', 'opel', 'Volkswagen', 'audi', 'toyota']),
				'model' => $faker->randomElement(['X6', 'Impreza', 'Astra', 'Polo', 'A3', 'Corolla']),
				'config' => $faker->randomElement(['min', 'standart', 'max']),
				'power' => $faker->numberBetween(90,300),
				'color' => $faker->randomElement(['red', 'green', 'white', 'black', 'blue']),
				'image' => $faker->randomElement([
					'http://s.auto.drom.ru/i24202/s/photos/23845/23844040/186521510.jpg',
					'http://s.auto.drom.ru/i24202/s/photos/23175/23174635/187794398.jpg',
					'http://s.auto.drom.ru/i24200/s/photos/22917/22916089/179381481.jpg',
					'http://s.auto.drom.ru/i24202/s/photos/24025/24024894/187909714.jpg',
					'http://s.auto.drom.ru/i24201/s/checked/1582110/8962243.jpg',
					'http://s.auto.drom.ru/i24202/s/checked/1734947/9842423.jpg',
				]),
				'price' => $faker->numberBetween(100000, 1000000),
				'status' => Car::STATUS_FREE,
			]);

			$this->getCarTable()->saveCar($car);
		}

		return new JsonModel(['test'], ['prettyPrint' => true]);
	}
}
