<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
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
}
