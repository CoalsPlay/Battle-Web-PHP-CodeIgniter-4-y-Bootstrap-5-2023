<?php

namespace App\Models;

use CodeIgniter\Model;

class News_m extends Model {

	protected $db;
    protected $table      	 = 'news_db';
    protected $primaryKey 	 = 'idNews';
    protected $allowedFields = ['titleNews', 'textNews'];

	public function __construct()
	{
		parent::__construct();
		$this->db = \Config\Database::connect();
	}

	/************************************************************************/

	//=======================================================================
	//	Apartado Noticias
	//=======================================================================

	// Insertar noticia en base de datos
	public function insertNews($dataPost)
	{
		$sql = $this->db->table('news_db')
						->insert($dataPost);
		return $sql;
	}

	// Obtener recuento de noticias totales
	public function numNews()
	{
		return $this->db->table('news_db')->countAllResults();
	}

	// Obtener noticia específica mediante ID
	public function getNews($idNews)
	{

		$sql = $this->db->table('news_db')
						->where('idNews', $idNews)
						->join('users_db', 'news_db.authorNews = users_db.id')
						->get();

		return $sql->getResultArray();
	}

	// Obtener datos de todas las noticias
	public function getAllNews()
	{
		$sql = $this->db->table('news_db')
						->join('users_db', 'news_db.authorNews = users_db.id')
						->get();

		return $sql->getResultArray();
	}

	// Actualizar el número de comentarios en una noticia mediante ID
	public function updateCommentsNews($idNews, $value)
	{
		$sql = $this->db->table('news_db')
						->where('idNews', $idNews)
						->update($value);
		return $sql;
	}

	// Actualizar noticias mediante ID
	public function updateNews($idNews, $set)
	{
		$sql = $this->db->table('news_db')
						->where('idNews', $idNews)
						->update($set);
		return $sql;
	}

	// Borrar noticia específica mediante ID
	public function deleteNews($idNews)
	{
		$sql = $this->db->table('news_db')
						->where('idNews', $idNews)
						->delete();
		$sql2 = $this->db->table('comments_db')
						 ->where('idNewsComment', $idNews)
						 ->delete();
		return $sql;
		return $sql2;
	}

	//=======================================================================
	//	Fin de apartado noticias
	//=======================================================================
	
}
