<?php

namespace App\Models;

use CodeIgniter\Model;

class Users_m extends Model {

	protected $db;
    protected $table      	 = 'users_db';
    protected $primaryKey 	 = 'id';
    protected $allowedFields = ['user', 'email', 'passw', 'tokenPassword', 'idUserInv', 'idItemInv'];

	public function __construct()
	{
		parent::__construct();
		$this->db = \Config\Database::connect();
	}

	// Obtiene todos los usuarios de la base de datos
	public function selectusers_db()
	{
		$sql = $this->db->table('users_db')
						->get()
						->getResultArray();

		return $sql;

	} 

	// Obtiene usuarios con un rango específico
	public function getRank($rank)
	{
		$sql = $this->db->table('users_db')
						->where('rank', $rank)
						->get();

		return $sql->getResultArray();
	}

	// Actualiza el rango de un usuario específico
	public function updateRank($idUser, $dataRank)
	{
		$set = [
			'rank' => $dataRank['rank']
		];

		$sql = $this->db->table('users_db')
						->where('id', $idUser)
						->update($set);
		return $sql;
	}

	// Obtiene un límite de usuarios con rango 0
	public function getUserMax($parameter, $maxTop)
	{
		$sql = $this->db->table('users_db')
						->where('rank', '0')
						->orderBy($parameter, 'DESC')
						->limit($maxTop)
						->get();

		return $sql->getResultArray();
	}

	// Obtiene un valor si email y username coinciden
	public function whereEmail($email, $username)
	{
		$sql = $this->db->table('users_db');
		$sql->where('email', $email);
		$sql->where('user', $username);

		if($sql->countAllResults() > 0)
		{
			return true;
		}else{
			return false;
		}

	}

	// Actualiza el valor de token mediante ID
	public function updateToken($id, $parameters)
	{
		$sql = $this->db->table('users_db');
		$sql->where('id', $id);
		$sql->update($parameters);

		return $sql;
	}

	// Actualiza la contraseña
	public function updatePassword($valuesWH, $valuesUP)
	{

		$sql = $this->db->table('users_db');
		$sql->where($valuesWH);
		$sql->update($valuesUP);

		return $sql;

	}

	// Obtiene un listado de todos los usuarios
	public function getUsers($per_page)
	{
		$sql = $this->db->table('users_db')
						->orderBy('id', 'DESC')
						->get();

		return $sql->getResultArray();
	}

	// Actualiza datos de un usuario específico mediante ID
	public function updateUserAll($id, $set)
	{

		$sql = $this->db->table('users_db')
						->where('id', $id)
						->update($set);
		return $sql;
	}

	// Actualiza la contraseña de un usuario específico mediante ID
	public function changeUserPass($dataUser)
	{
		$set = [
			'passw' => $dataUser['newPass'],
		];

		$sql = $this->db->table('users_db')
						->where('id', $dataUser['idUser'])
						->update($set);
		return $sql;
	}

	// Actualiza la configuración de un usuario específico
	public function updateUserConfig($dataUser)
	{
		$set = [
			'aboutMe' => $dataUser['aboutMe'],
			'gender' => $dataUser['gender'],
			'theme' => $dataUser['theme'],
			'twitter' => $dataUser['twitter'],
			'facebook' => $dataUser['facebook'],
			'youtube' => $dataUser['youtube']
		];

		$sql = $this->db->table('users_db')
						->where('id', $dataUser['idUser'])
						->update($set);
		return $sql;		
	}

	// Borra un usuario específico mediante ID, sus comentarios y sus noticias
	public function deleteUser($idUser)
	{
		$sql1 = $this->db->table('users_db')
						 ->where('id', $idUser)
						 ->delete();

		$sql2 = $this->db->table('comments_db')
						 ->where('authorComment', $idUser)
						 ->delete();
						 
		$sql3 = $this->db->table('news_db')
						 ->where('authorNews', $idUser)
						 ->delete();

		return $sql1;
		return $sql2;
		return $sql3;
	}

	// Obtiene un resultado de búsqueda basado en usuarios
	public function getUsersSearch($dataSearch)
	{
		$sql = $this->db->table('users_db')
						->like('users_db', $dataSearchta)
						->get();

		return $sql->countAllResults();
	}

	// Obtener un usuario específico mediante ID
	public function getUserId($id)
	{
		$sql = $this->db->table('users_db')
						->where('id', $id)
						->get()
						->getResultArray();

		return $sql[0];
	}

	// Obtiene la cuantía de usuarios registrados
	public function numUsers()
	{
		return $this->db->table('users_db')
						->countAllResults();
	}

	// Registra un usuario en la base de datos
	public function registerUser($values){

		$sql = $this->db->table('users_db')
						->insert([
							'user' => $values['usernameR'],
							'email' => $values['emailR'],
							'passw' => $values['passwordR'],
							'registrationDate' => date("Y-m-d"),
							'registrationTime' => date("H:i"),
							'ip' => $values['ip'],
						]);
		return $sql;
	}

	// Obtiene un usuario específico mediante nombre
	public function getUser($user)
	{
		$sql = $this->db->table('users_db')
						->where('user', $user)
						->get()
						->getResultArray();

		return $sql[0];
	}
	
	// Aumenta atributos de un usuario específico
	public function updateAtr($user, $values)
	{
		$sql = $this->db->table('users_db')
						->where('user', $user)
						->update($values);
		return $sql;
	}

	// Obtener el número de users_db registrados.
	public function countUsers()
	{
		return $this->db->table('users_db')
						->countAllResults();
	}
	
	public function updateParameterUser($parameter, $countParameter, $idUser)
	{
		$set = [
			$parameter => $countParameter
		];

		$sql = $this->db->table('users_db')
						->where('id', $idUser)
						->update($set);
		return $sql;
	}

	// Verifica si un token es válido y obtiene sus valores
	public function checkToken($token)
	{
		$sql = $this->db->table('users_db');
		$sql->where('tokenPassword', $token);
		$sql->get();

		if($sql->countAllResults() > 0)
		{
			return $sql->getFirstRow();
		}else{
			return FALSE;
		}
	}

	// Inserta un avatar en la base de datos
	public function uploadAvatar($dataAvatar, $idUser)
	{
		$set = [
			'avatar' => $dataAvatar
		];

		$sql = $this->db->table('users_db')
						->where('id', $idUser)
						->update($set);
		return $sql;
	}

	/************************************************************************/
	
}
