<?php

namespace App\Models;

use CodeIgniter\Model;

class Comments_m extends Model {

	protected $db;
    protected $table      	 = 'comments_db';
    protected $primaryKey 	 = 'idComment';
    protected $allowedFields = ['textComment', 'authorComment'];

	public function __construct()
	{
		parent::__construct();
		$this->db = \Config\Database::connect();
	}

	/************************************************************************/

	//=======================================================================
	//	Apartado Comentarios
	//=======================================================================

	// Insertar comentario en la base de datos
	public function insertComment($dataPost)
	{
		$sql = $this->db->table('comments_db')
						->insert($dataPost);
		return $sql;
	}

	// Borrar un comentario específico mediante ID
	public function deleteComment($idComment)
	{
		$sql = $this->db->table('comments_db')
						->where('idComment', $idComment)
						->delete();
		return $sql;
	}

	// Obtener recuento total de comentarios
	public function numComments()
	{
		return $this->db->table('comments_db')->countAllResults();
	}

	// Obtener número de comentarios de una noticia específica mediante ID
	public function numCommentsId($idNews)
	{
		$sql = $this->db->table('comments_db')
						->where('idNewsComment', $idNews);

		return $sql->countAllResults();
	}

	//=======================================================================
	//	Fin de apartado de comentarios
	//=======================================================================
	
}
