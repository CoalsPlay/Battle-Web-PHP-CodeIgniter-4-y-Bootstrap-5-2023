<?php

namespace App\Models;

use CodeIgniter\Model;

class Inventory_m extends Model {

	protected $db;
    protected $table      	 = 'inventories_db';
    protected $primaryKey 	 = 'idInventory';
    protected $allowedFields = ['idUserInv', 'idItemInv'];

	public function __construct()
	{
		parent::__construct();
		$this->db = \Config\Database::connect();
	}

	/************************************************************************/

	//=======================================================================
	//	Apartado Inventario
	//=======================================================================

	// Inserta un objeto al inventario
	public function insertInventory($dataItem)
	{
		$sql = $this->db->table('inventories_db')
						->insert($dataItem);
		return $sql;
	}

	// Obtiene todos los objetos del inventario
	public function getItemsInv($idUser)
	{
		$sql = $this->db->table('inventories_db')
						->where('idUserInv', $idUser)
						->orderBy('idInventory', 'DESC')
						->join('shop_db', 'inventories_db.idItemInv = shop_db.idItem')
						->get();

		return $sql->getResultArray();
	}

	// Obtiene la cuantía de objetos de un inventario
	public function numItemsUser($idUser)
	{
		$sql = $this->db->table('inventories_db')
						->where('idUserInv', $idUser)
						->join('shop_db', 'inventories_db.idItemInv = shop_db.idItem');

		return $sql->countAllResults();
	}

	// Obtiene objetos de un inventario específico mediante ID
	public function getItemInv($idInv)
	{
		$sql = $this->db->table('inventories_db')
						->where('idInventory', $idInv)
						->join('shop_db', 'inventories_db.idItemInv = shop_db.idItem')
						->get();

		return $sql->getResultArray();
	}

	// Borra un objeto de la base de datos
	public function deleteItemInv($idInv)
	{
		$sql = $this->db->table('inventories_db')
						->where('idInventory', $idInv)
						->delete();
		return $sql;		
	}

	//=======================================================================
	//	Fin de apartado Inventario
	//=======================================================================
	
}
