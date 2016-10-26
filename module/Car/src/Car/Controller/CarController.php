<?php

namespace Car\Controller;

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
		$result = [
			'success' => true,
			'cars' => $this->getCarTable()->fetchAll(),
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
}
