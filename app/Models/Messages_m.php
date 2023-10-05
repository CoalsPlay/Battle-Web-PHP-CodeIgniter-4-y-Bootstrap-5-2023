<?php

namespace App\Models;

use CodeIgniter\Model;

class Messages_m extends Model {

	protected $db;
    protected $table      	 = 'messages_db';
    protected $primaryKey 	 = 'idMsg';
    protected $allowedFields = ['idAuthorMsg', 'idReceiverMsg'];

	public function __construct()
	{
		parent::__construct();
		$this->db = \Config\Database::connect();
	}

	/************************************************************************/

	//=======================================================================
	//	Apartado Mensajería privada
	//=======================================================================

	// Inserta un mensaje en la base de datos
	public function insertMsg($dataPost, $idReceiver)
	{
		$sql = $this->db->table('messages_db')
						->insert([
							'idAuthorMsg' => $dataPost['idAuthorMsg'],
							'idReceiverMsg' => $idReceiver,
							'receiverNameMsg' => $dataPost['toMsg'],
							'titleMsg' => $dataPost['titleMsg'],
							'textMsg' => $dataPost['textMsg'],
							'dateMsg' => date('Y-m-d H:i'),
						]);
		return $sql;
	}

	// Obtiene los mensajes sin leer de un usuario específico mediante ID
	public function unreadMsg($idUser)
	{
		$sql = $this->db->table('messages_db')
						->where('idReceiverMsg', $idUser)
						->where('statusMsg', '0');

		return $sql->countAllResults();
	}

	// Actualiza el valor de estado de un mensaje específico mediante ID
	public function updateStatusId($idMsg)
	{
		$set = [
			'statusMsg' => '1'
		];

		$sql = $this->db->table('messages_db')
						->where('idMsg', $idMsg)
						->update($set);
		return $sql;
	}
	
	// Actualizar el estado de un mensaje de un usuario específico mediante ID
	public function updateStatusMsg($idUser)
	{
		$set = [
			'statusMsg' => '1'
		];

		$sql = $this->db->table('messages_db')
						->where('idReceiverMsg', $idUser)
						->update($set);
		return $sql;
	}

	//=======================================================================
	//	Fin de apartado Mensajería privada
	//=======================================================================
	
}
