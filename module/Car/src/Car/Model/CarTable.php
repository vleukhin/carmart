<?php

namespace Car\Model;

use Zend\Db\TableGateway\TableGateway;

class CarTable
{
	protected $tableGateway;

	/**
	 * CarTable constructor.
	 *
	 * @param TableGateway $tableGateway
	 */
	public function __construct(TableGateway $tableGateway)
	{
		$this->tableGateway = $tableGateway;
	}

	/**
	 * Метод получения всех авто
	 *
	 * @return \Zend\Db\ResultSet\ResultSet
	 */
	public function fetchAll()
	{
		$resultSet = $this->tableGateway->select();
		return $resultSet;
	}

	/**
	 * Метод поиска авто по id
	 *
	 * @param $id
	 * @return array|\ArrayObject|null
	 * @throws \Exception
	 */
	public function getCar($id)
	{
		$id  = (int) $id;
		$rowset = $this->tableGateway->select(['id' => $id]);
		$row = $rowset->current();
		if (!$row) {
			throw new \Exception("Could not find row $id");
		}
		return $row;
	}

	/**
	 * Метод сохранения авто
	 *
	 * @param Car $car
	 * @throws \Exception
	 */
	public function saveCar(Car $car)
	{
		$data = $car->toArray();

		$id = (int) $car->id;
		if ($id == 0) {
			$this->tableGateway->insert($data);
		} else {
			if ($this->getCar($id)) {
				$this->tableGateway->update($data, ['id' => $id]);
			} else {
				throw new \Exception('Car id does not exist');
			}
		}
	}
}