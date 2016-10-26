<?php

namespace Car\Controller;

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
			'cars' => !empty($cars) ?: [],
		];

		return new JsonModel($result, ['prettyPrint' => true]);
	}

	public function getCarTable()
	{
		if (!$this->carTable) {
			$sm = $this->getServiceLocator();
			$this->carTable = $sm->get('Car\Model\CarTable');
		}

		return $this->carTable;
	}

	public function generateAction()
	{
		return new JsonModel(['test'], ['prettyPrint' => true]);
	}
}
