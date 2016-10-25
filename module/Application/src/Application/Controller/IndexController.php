<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
	/**
	 * Главная страница
	 *
	 * @return ViewModel
	 */
	public function indexAction()
	{
		return new ViewModel();
	}

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

		return new JsonModel([
			'success' => true,
			'cars' => [$car, $car],
		]);
	}
}
