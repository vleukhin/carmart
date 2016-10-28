<?php

namespace Car\Controller;

use Car\Model\Car;
use Car\Model\CarTable;
use Faker\Factory as FakerFactory;
use Zend\Db\Adapter\Exception\InvalidQueryException;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

class CarController extends AbstractRestfulController
{
	protected $carTable;

	/**
	 * Получаем список авто
	 *
	 * @return JsonModel
	 */
	public function getList()
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
		$cars = [];

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
			$cars[] = $car;
		}

		return new JsonModel(['cars' => $cars], ['prettyPrint' => true]);
	}

	/**
	 * Метод обновления статуса авто
	 *
	 * @return void|JsonModel
	 */
	public function update($id, $data)
	{
		$request = $this->getRequest();

		if ($request->isPost())
		{
			$error = '';
			$result = [];

			$id = (int) $this->params()->fromRoute('id', 0);



			if (isset($car))
			{
				$status_id = $request->getPost('status_id');

				if (in_array($status_id, Car::getConstants('STATUS')))
				{
					$car->status = $status_id;
					$this->getCarTable()->saveCar($car);
				}
				else
				{
					$error = 'Неверный статус';
				}

				$result['car'] = $car;
			}

			$result['success'] = empty($error);
			if (!empty($error))
			{
				$result['error'] = $error;
			}

			return new JsonModel($result, ['prettyPrint' => true]);
		}

		$this->getResponse()->setStatusCode(404);
	}

	/**
	 * Return single resource
	 *
	 * @param  mixed $id
	 * @return mixed
	 */
	public function get($id)
	{
		$car = $this->findCar($id);

		if ($car)
		{
			return $this->response($car->toArray());
		}

		return $this->response($this->notFoundAction());
	}

	/**
	 * Поиск авто по id
	 *
	 * @param $id
	 * @return Car|null
	 */
	protected function findCar($id)
	{
		$car = null;

		try
		{
			$car = $this->getCarTable()->getCar($id);
		}
			/**
			 * Zend не кидает конкретное исключение (да и зачем здесь вообще исключение?)
			 * Приходится ловить всё
			 */
		catch (\Exception $e){
		}

		return $car;
	}

	/**
	 * Возвращаем ответ в JSON
	 *
	 * @param $data
	 * @return JsonModel
	 */
	protected function response($data)
	{
		return new JsonModel($data, ['prettyPrint' => true]);
	}
}
