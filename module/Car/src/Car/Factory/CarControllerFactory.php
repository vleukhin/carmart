<?php

namespace Car\Factory;

use Car\Model\CarTable;
use Car\Controller\CarController;
use Zend\ServiceManager\FactoryInterface;

class CarControllerFactory implements FactoryInterface
{
	/**
	 * Create service
	 *
	 * @param \Zend\ServiceManager\ServiceLocatorInterface $serviceLocator
	 * @return mixed
	 */
	public function createService(\Zend\ServiceManager\ServiceLocatorInterface $serviceLocator)
	{
		return new CarController($serviceLocator->getServiceLocator()->get(CarTable::class));
	}
}