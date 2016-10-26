<?php

namespace Car\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;

class CarController extends AbstractActionController
{
	/**
	 * Получаем список авто
	 *
	 * @return JsonModel
	 */
	public function listAction()
	{
		$car = [
			'brand' => 'bmw',
			'model' => 'X6',
			'config' => '',
			'power' => 200,
			'color' => 'red',
			'image' => 'bmw.jpg',
			'price' => 4000000,
		];

		$result = [
			'success' => true,
			'cars' => [$car, $car],
		];

		return new JsonModel($result, ['prettyPrint' => true]);
	}
}
