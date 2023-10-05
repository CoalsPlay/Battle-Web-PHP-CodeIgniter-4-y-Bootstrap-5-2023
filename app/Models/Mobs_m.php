<?php

namespace App\Models;

use CodeIgniter\Model;

class Mobs_m extends Model {

	protected $db;
    protected $table      	 = 'mobs_db';
    protected $primaryKey 	 = 'idMob';
    protected $allowedFields = [];

	public function __construct()
	{
		parent::__construct();
		$this->db = \Config\Database::connect();
	}

	//=======================================================================
	//	Apartado Mobs
	//=======================================================================

	// Agregar un mob a la base de datos.
	public function insertMob($dataPost)
	{
		$sql = $this->db->table('mobs_db')
						->insert($dataPost);
		return $sql;
	}

	// Recuento de todos los mobs añadidos.
	public function numMobs()
	{
		return $sql = $this->db->table('mobs_db')->countAllResults();
	}

	// Obtener todos los mobs con orden de nuevos a viejos y uníendo datos con la tabla de maps_db.
	public function getMobs()
	{
		$sql = $this->db->table('mobs_db')
						->orderBy('idMob', 'DESC')
						->join('maps_db', 'mobs_db.idMapMob = maps_db.idMap')
						->get();

		return $sql->getResultArray();
	}

	// Obtener un mob mediante su ID.
	public function getMob($idMob)
	{
		$sql = $this->db->table('mobs_db')
						->where('idMob', $idMob)
						->join('maps_db', 'mobs_db.idMapMob = maps_db.idMap')
						->get();

		return $sql->getResultArray();
	}

	// Actualizar parámetros de un mob.
	public function updateMob($idMob, $set)
	{
		$sql = $this->db->table('mobs_db')
						->where('idMob', $idMob)
						->update($set);
		return $sql;
	}

	// Borrar un mob
	public function deleteMob($idMob)
	{
		$sql = $this->db->table('mobs_db')
						->where('idMob', $idMob)
						->delete();
		return $sql;		
	}

	// Obtener un mob al azar
	public function randomMob($idMap)
	{

		$sql = $this->db->table('mobs_db')
						->where('idMapMob', $idMap)
						->orderBy('rand()')
						->join('maps_db', 'mobs_db.idMapMob = maps_db.idMap')
						->limit(1)
						->get();

		return $sql->getResultArray();
	}

	//=======================================================================
	//	Fin de apartado Mobs
	//=======================================================================
	
}
