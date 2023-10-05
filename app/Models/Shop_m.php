<?php

namespace App\Models;

use CodeIgniter\Model;

class Shop_m extends Model {

	protected $db;
    protected $table      	 = 'shop_db';
    protected $primaryKey 	 = 'idInventory';
    protected $allowedFields = ['idUserInv', 'idItemInv'];

	public function __construct()
	{
		parent::__construct();
		$this->db = \Config\Database::connect();
	}

	/************************************************************************/

	//=======================================================================
	//	Apartado Tienda
	//=======================================================================

	// Actualiza los valores de un producto específico mediante ID
	public function updateItem($idItem, $set)
	{
		$sql = $this->db->table('shop_db')
						->where('idItem', $idItem)
						->update($set);
		return $sql;
	}

	// Obtiene un producto específico mediante ID
	public function getItem($idItem)
	{
		$sql = $this->db->table('shop_db')
						->where('idItem', $idItem)
						->get();

		return $sql->getResultArray();		
	}

	// Inserta un producto a la base de datos
	public function insertItem($dataItem)
	{
		$sql = $this->db->table('shop_db')
						->insert($dataItem);
		return $sql;
	}

	// Obtiene la cuantía de objetos de un usuario
	public function numItemsUser($idUser)
	{
		$sql = $this->db->table('inventories_db')
						->where('idUserInv', $idUser)
						->join('shop_db', 'inventories_db.idItemInv = shop_db.idItem');

		return $sql->countAllResults();
	}

	// Borra un producto específico mediante ID de la base de datos
	public function deleteItem($idItem)
	{
		$sql = $this->db->table('shop_db')
						->where('idItem', $idItem)
						->delete();
		return $sql;		
	}

	//=======================================================================
	//	Fin de apartado tienda
	//=======================================================================
	
}
