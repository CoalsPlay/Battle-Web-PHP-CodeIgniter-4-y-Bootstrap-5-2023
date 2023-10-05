<?php

namespace App\Models;

use CodeIgniter\Model;

class Friends_m extends Model {

	protected $db;
    protected $table      	 = 'friends_db';
    protected $primaryKey 	 = 'idFriends';
    protected $allowedFields = [];

	public function __construct()
	{
		parent::__construct();
		$this->db = \Config\Database::connect();
	}

	/************************************************************************/

	//=======================================================================
	//	Sistema de amigos
	//=======================================================================

	// Inserta una petición en base de datos
	public function insertRequest($dataRequest)
	{
		$sql = $this->db->table('requests_db')
						->insert($dataRequest);
		return $sql;
	}

	// Verifica si dos usuarios son amigos
	public function checkFriends($user_1, $user_2)
	{
		$sql = $this->db->table('friends_db')
						->where('idFriend1', $user_1)
						->where('idFriend2', $user_2);
		
		if($sql->countAllResults() > 0)
		{
			return TRUE;
		}else{
			return FALSE;
		}
	}

	// Verifica si los dos usuarios se han enviado petición mutuamente
	public function checkRequests($user_1, $user_2)
	{
		$sql = $this->db->table('requests_db')
						->where(['idAuthorRequest' => $user_1, 'idReceiverRequest' => $user_2])
						->where('statusRequest', '0');

		if($sql->countAllResults() > 0)
		{
			return true;
		}else{
			return false;
		}
	}

	// Obtiene peticiones de amistad mediante ID
	public function getRequestsId($idUser)
	{
		$sql = $this->db->table('requests_db')
						->where('idReceiverRequest', $idUser)
						->where('statusRequest', '0')
						->join('users_db', 'requests_db.idAuthorRequest = users_db.id')
						->get();

		return $sql->getResultArray();
	}

	// Obtiene la cuantía de peticiones de amistad de un usuario mediante ID
	public function numRequestsId($idUser)
	{
		$sql = $this->db->table('requests_db')
						->where('idReceiverRequest', $idUser)
						->where('statusRequest', '0');

		return $sql->countAllResults();
	}

	// Actualiza el valor de estado de una petición
	public function updateStatusRequest($idAuthorRequest, $idReceiverRequest)
	{
		$set = [
			'statusRequest' => '1'
		];

		$sql = $this->db->table('requests_db')
						->where('idAuthorRequest', $idAuthorRequest)
						->where('idReceiverRequest', $idReceiverRequest)
						->update($set);
		return $sql;
	}

	// Inserta los registros de amistad entre dos usuarios
	public function insertFriend($user1, $user2)
	{
		$sql = $this->db->table('friends_db')
						->insert([
							'idFriend1' => $user1,
							'idFriend2' => $user2,
							'dateFriend' => date('Y-m-d H:i')
						]);
		return $sql;
	}

	// Borra una petición específica de la base de datos
	public function deleteRequest($idUser1, $idUser2)
	{
		$sql = $this->db->table('requests_db')
						->where('idAuthorRequest', $idUser1)
						->where('idReceiverRequest', $idUser2)
						->delete();

		return $sql;
	}

	// Obtiene la cuantía de amigos de un usuario específico mediante ID
	public function numFriendId($idUser)
	{
		$sql = $this->db->table('friends_db')
						->where('idFriend1', $idUser);

		return $sql->countAllResults();
	}

	// Obtiene los amigos que tiene un usuario específico mediante ID
	public function getFriends($idUser)
	{
		$sql = $this->db->table('friends_db')
						->where('idFriend1', $idUser)
						->orderBy('idFriends', 'DESC')
						->join('users_db', 'friends_db.idFriend2 = users_db.id')
						->get();

		return $sql->getResultArray();
	}

	// Obtiene amigos de un usuario específico mediante ID para mostrar en su perfil
	public function getFriendsProfile($idUser)
	{
		$sql = $this->db->table('friends_db')
						->where('idFriend1', $idUser)
						->orderBy('idFriends', 'DESC')
						->join('users_db', 'friends_db.idFriend2 = users_db.id')
						->get();

		return $sql->getResultArray();
	}

	// Borra los registros de una amistad de entre dos usuarios
	public function deleteFriend($idUser1, $idUser2)
	{
		$sql = $this->db->table('friends_db')
						->where('idFriend1', $idUser1)
						->where('idFriend2', $idUser2)
						->delete();
		return $sql;
	}

	// Borra una petición de amistad si los usuarios ya son amigos
	public function deleteRequestFriend($idUser1, $idUser2)
	{
		$sql = $this->db->table('requests_db')
						->where(['idAuthorRequest' => $idUser1, 'idReceiverRequest' => $idUser2])
						->orWhere(['idAuthorRequest' => $idUser2, 'idReceiverRequest' => $idUser1])
						->delete();
		return $sql;
	}

	//=======================================================================
	//	End system friends
	//=======================================================================
	
}
