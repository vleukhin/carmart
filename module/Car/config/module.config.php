<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Car;

return array(
	'db' => array(
		'driver' => 'Pdo',
		'dsn' => 'mysql:dbname=carmart;host=localhost',
		'driver_options' => array(
			\PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
		),
	),
	'router' => array(
		'routes' => array(
			'home' => array(
				'type' => 'literal',
				'options' => array(
					'route' => '/',
					'defaults' => array(
						'controller' => 'Car\Controller\Index',
						'action' => 'index',
					),
				),
			),
			'cars' => array(
				'type'    => 'segment',
				'options' => array(
					'route'    => '/cars[/:id]',
                    'constraints' => array(
                        'id'     => '[0-9]+',
                    ),
					'defaults' => array(
						'controller' => 'Car\Controller\Car',
					),
				),
			),
			'cars_generate' => array(
				'type' => 'literal',
				'options' => array(
					'route' => '/cars/generate',
					'defaults' => array(
						'controller' => 'Car\Controller\Car',
						'action' => 'generate',
					),
				),
			),
		),
	),
	'controllers' => array(
		'invokables' => array(
			'Car\Controller\Index' => 'Car\Controller\IndexController',
			'Car\Controller\Car' => 'Car\Controller\CarController',
		),
	),
	'view_manager' => array(
		'template_path_stack' => array(
			'album' => __DIR__ . '/../view',
		),
		'strategies' => array(
			'ViewJsonStrategy',
		),
	),
	'service_manager' => array(
		'abstract_factories' => array(
			'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
			'Zend\Log\LoggerAbstractServiceFactory',
		),
		'factories' => array(
			'translator' => 'Zend\Mvc\Service\TranslatorServiceFactory',
			'Zend\Db\Adapter\Adapter' => 'Zend\Db\Adapter\AdapterServiceFactory',
		),
	),
	// Placeholder for console routes
	'console' => array(
		'router' => array(
			'routes' => array(),
		),
	),
);