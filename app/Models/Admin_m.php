<?php

namespace App\Models;

use CodeIgniter\Model;

class Admin_m extends Model {

	protected $db;
    protected $table      = 'settings_db';
    protected $allowedFields = [];

	public function __construct()
	{
		parent::__construct();
		$this->db = \Config\Database::connect();
	}

	//=======================================================================
	//	Configuración global
	//=======================================================================

	// Obtiene la información del sitio
	public function getInfoSite()
	{
		$sql = $this->db->table('settings_db')
						->get()
						->getResultArray();

		return $sql[0];
	}

	// Actualiza los valores de la información del sitio
	public function updateInfoSite($parameter)
	{
		$set = [
				'siteName' => $parameter['siteName'],
				'siteDescript' => $parameter['siteDescript'],
				'maintenance' => $parameter['maintenance'],
				'titleMaintenance' => $parameter['titleMaintenance'],
				'descriptMaintenance' => $parameter['descriptMaintenance'],
				'emailName' => $parameter['emailName'],
				'siteEmail' => $parameter['siteEmail'],
				'userTwitter' => $parameter['userTwitter']
		];

		$sql = $this->db->table('settings_db')
						->update($set);

		return $sql;
	}

	// Actualiza los valores de las opciones de juego
	public function updateGameOptions($parameter)
	{
		$set = [
				'maxLvl' => $parameter['maxLvl'],
				'attributePointsPerLvl' => $parameter['attributePointsPerLvl'],
				'intervalExp' => $parameter['intervalExp'],
				'intervalLvl' => $parameter['intervalLvl'],
				'maxTop' => $parameter['maxTop'],
				'maxItemsInventory' => $parameter['maxItemsInventory'],
				'maxFriends' => $parameter['maxFriends'],
				'moneyName' => $parameter['moneyName']
		];

		$sql = $this->db->table('settings_db')
						->update($set);

		return $sql;
	}

	//=======================================================================
	//	Apartado FAQs
	//=======================================================================

	// Actualiza el valor de la descripción de la sección FAQ
	public function updateHelpFaq($set)
	{

		$sql = $this->db->table('settings_db')
						->update($set);

		return $sql;
	}

	// Inserta un FAQ en la base de datos
	public function insertFaq($set)
	{

		$sql = $this->db->table('faq_db')
						->insert($set);

		return $sql;
	}

	// Obtiene todos los FAQs en array
	public function getFaqs()
	{
		$sql = $this->db->table('faq_db')
						->orderBy('idFaq', 'DESC')
						->get();

		return $sql->getResultArray();
	}

	// Obtiene un FAQ específico mediante ID
	public function getFaqId($idFaq)
	{
		$sql = $this->db->table('faq_db')
						->where('idFaq', $idFaq)
						->get();

		return $sql->getResultArray();	
	}

	// Actualiza valores de un FAQ mediante ID
	public function updateFaq($idFaq, $set)
	{
		$sql = $this->db->table('faq_db')
						->where('idFaq', $idFaq)
						->update($set);

		return $sql;
	}

	// Borra un FAQ específico mediante ID.
	public function deleteFaq($idFaq)
	{
		$sql = $this->db->table('faq_db')
						->where('idFaq', $idFaq)
						->delete();
		return $sql;
	}

	//=======================================================================
	//	Fin de apartado FAQs
	//=======================================================================

	/************************************************************************/

	// Inserta una categoría en la base de datos
	public function insertCategory($dataPost)
	{
		$sql = $this->db->table('maps_categories_db')
						->insert($dataPost);

		return $sql;
	}

	// Obtiene un array de todas las categorías
	public function getCategories()
	{
		$sql = $this->db->table('maps_categories_db')
						->get();

		return $sql->getResultArray();
	}

	// Obtiene una categoría mediante ID
	public function getCategoryId($idCategory)
	{
		$sql = $this->db->table('maps_categories_db')
						->where('idCategory', $idCategory)
						->get();

		return $sql->getResultArray();
	}

	// Actualiza los valores de una categoría
	public function updateCategory($idCategory, $set)
	{
		$sql = $this->db->table('maps_categories_db')
						->where('idCategory', $idCategory)
						->update($set);

		return $sql;
	}

	// Borra una categoría y sus mapas asociados
	public function deleteCategoryAndMaps($dataPost)
	{
		$sql = $this->db->table('maps_categories_db')
						->where('idCategory', $dataPost['idCategory'])
						->delete();

		$sql2 = $this->db->table('maps_db')
						 ->where('idCategoryMap', $dataPost['idCategory'])
						 ->delete();
		return $sql;
		return $sql2;
	}

	// Inserta un mapa en la base de datos
	public function insertMap($dataPost)
	{
		$sql = $this->db->table('maps_db')
						->insert($dataPost);

		return $sql;
	}

	// Obtiene un array de todos los mapas
	public function getMaps()
	{
		$sql = $this->db->table('maps_db')
						->join('maps_categories_db', 'maps_db.idCategoryMap = maps_categories_db.idCategory')
						->orderBy('idMap', 'DESC')
						->get();

		return $sql->getResultArray();
	}

	// Actualiza valores de un mapa mediante ID
	public function updateMap($idMap, $set)
	{
		$sql = $this->db->table('maps_db')
						->where('idMap', $idMap)
						->update($set);
		return $sql;
	}

	// Obtiene un mapa mediante ID
	public function getMapId($idMap)
	{
		$sql = $this->db->table('maps_db')
						->where('idMap', $idMap)
						->join('maps_categories_db', 'maps_db.idCategoryMap = maps_categories_db.idCategory')
						->get();

		return $sql->getResultArray();
	}

	// Obtiene mapas asociados mediante categoría
	public function getMapsByCategory($idCategory)
	{
		$sql = $this->db->table('maps_db')
						->where('idCategoryMap', $idCategory)
						->join('maps_categories_db', 'maps_db.idCategoryMap = maps_categories_db.idCategory')
						->orderBy('idMap', 'DESC')
						->get();

		return $sql->getResultArray();
	}

	// Borra un mapa específico mediante ID
	public function deleteMap($idMap)
	{
		$sql = $this->db->table('maps_db')
						->where('idMap', $idMap)
						->delete();
		return $sql;
	}

	//=======================================================================
	//	Fin de apartado configuración global
	//=======================================================================

	/************************************************************************/

	//=======================================================================
	//	Apartado Feedback
	//=======================================================================

	/**********************
		Bugs
	***********************/

	// Inserta un ticket de bug a la base de datos
	public function insertBug($dataBug)
	{
		$sql = $this->db->table('bugs_db')
						->insert([
							'textBug' => $dataBug['textBug'],
							'authorBug' => $dataBug['authorBug'],
							'dateBug' => date("Y-m-d H:i")
						]);
		return $sql;
	}

	// Obtiene un registro de bugs mediante ID
	public function getBugs()
	{
		$sql = $this->db->table('bugs_db')
						->orderBy('idBug', 'DESC')
						->join('users_db', 'bugs_db.authorBug = users_db.id')
						->get();

		return $sql->getResultArray();
	}

	/**********************
		Suggestions
	***********************/

	// Inserta un registro de sugerencias a la base de datos
	public function insertSuggestion($dataSuggestion)
	{
		$sql = $this->db->table('suggestions_db')
						->insert([
							'textSuggestion' => $dataSuggestion['textSuggestion'],
							'authorSuggestion' => $dataSuggestion['authorSuggestion'],
							'dateSuggestion' => date("Y-m-d H:i")
							]);
		return $sql;
	}

	// Obtiene todos los registros de sugerencias
	public function getSuggestions()
	{
		$sql = $this->db->table('suggestions_db')
						->orderBy('idSuggestion', 'DESC')
						->join('users_db', 'suggestions_db.authorSuggestion = users_db.id')
						->get();

		return $sql->getResultArray();
	}

	//=======================================================================
	//	Fin de apartado Feedback
	//=======================================================================

	/************************************************************************/

	//=======================================================================
	//	Apartado de Mapa y Combate
	//=======================================================================

	// Obtiene todos los mobs asociados a un mapa específico mediante ID
	public function getMobByMap($idMap)
	{
		$sql = $this->db->where('idMapMob', $idMap)
						->get('mobs');

		return $sql->result();
	}

	// Inserta un combate en la base de datos
	public function insertFight($dataPost)
	{
		$sql = $this->db->table('fights_db')
						->insert([
							'idUserFight' => $dataPost['idUser'],
							'idEnemyFight' => $dataPost['idMob'],
							'healthEnemyFight' => $dataPost['healthMob'],
							'maxHealthEnemyFight' => $dataPost['maxHealthMob'],
							'atkEnemyFight' => $dataPost['atkMob'],
							'timeFight' => time()
						]);
		return $sql;
	}

	// Verifica si hay un combate de un usuario específico mediante ID
	public function checkFight($idUser)
	{
		$sql = $this->db->table('fights_db')
						->where('idUserFight', $idUser)
						->join('mobs_db', 'fights_db.idEnemyFight = mobs_db.idMob')
						->get();

		return $sql->getResultArray();
	}

	// Verifica si hay un duelo activo de un usuario específico mediante ID
	public function statusFight($idUser)
	{
		$sql = $this->db->table('fights_db')
						->where('idUserFight', $idUser);

		if($sql->countAllResults() > 0)
		{
			return true;
		}else{
			return false;
		}
	}

	// Verifica si un duelo de un usuario mediante ID está activo
	public function checkFightActive($idUser)
	{
		$sql = $this->db->table('fights_db')
						->where('idUserFight', $idUser);

		if($sql->countAllResults() == 0)
		{
			return TRUE;
		}else{
			return FALSE;
		}
	}

	// Borra un duelo específico de la base de datos
	public function deleteFight($idFight)
	{
		$sql = $this->db->table('fights_db')
						->where('idFight', $idFight)
						->delete();
		return $sql;
	}

	// Actualiza los valores de un combate específico
	public function updateFight($parameter, $valueParameter, $idFight)
	{
		$set = [
			$parameter => $valueParameter
		];

		$sql = $this->db->table('fights_db')
						->where('idFight', $idFight)
						->update($set);
		return $sql;
	}

	// Inserta un duelo en la base de datos
	public function insertArena($dataPost)
	{
		$sql = $this->db->table('arenas_db')
						->insert(array(
							'idUser1' => $dataPost['idUser1'],
							'idUser2' => $dataPost['idUser2'],
							'atkEnemyArena' => $dataPost['atkEnemyArena'],
							'healthEnemyArena' => $dataPost['healthEnemyArena'],
							'maxHealthEnemyArena' => $dataPost['maxHealthEnemyArena'],
							'energyEnemyArena' => $dataPost['energyEnemyArena'],
							'maxEnergyEnemyArena' => $dataPost['maxEnergyEnemyArena']
						));
		return $sql;
	}

	// Obtiene el estado de un duelo de ambos usuarios
	public function statusArenaBoth($idUser)
	{
		$sql = $this->db->table('arenas_db')
						->where('idUser2', $idUser)
						->orWhere('idUser1', $idUser);

		if($sql->countAllResults() == 1)
		{
			return TRUE;
		}else{
			return FALSE;
		}
	}

	// Obtiene el estado de un duelo
	public function statusArena($idUser)
	{
		$sql = $this->db->table('arenas_db')
						->where('idUser1', $idUser);

		if($sql->countAllResults() == 1)
		{
			return TRUE;
		}else{
			return FALSE;
		}
	}

	// Verifica que un usuario esté en un duelo
	public function checkArena($idUser)
	{
		$sql = $this->db->table('arenas_db')
						->where('idUser1', $idUser)
						->join('users_db', 'arenas_db.idUser2 = users_db.id')
						->get();

		return $sql->getResultArray();
	}

	// Actualiza los valores de un duelo
	public function updateArena($parameter, $valueParameter, $idArena)
	{
		$set = [
			$parameter => $valueParameter
		];

		$sql = $this->db->table('arenas_db')
						->where('idArena', $idArena)
						->update($set);
		return $sql;
	}

	// Borra un duelo de la base de datos
	public function deleteArena($idArena)
	{
		$sql = $this->db->table('arenas_db')
						->where('idArena', $idArena)
						->delete();
		return $sql;
	}

	//=======================================================================
	//	Fin de apartado de Mapa y Combate
	//=======================================================================

	/************************************************************************/
}
