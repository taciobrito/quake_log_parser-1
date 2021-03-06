<?php 

namespace App\Models;

use App\Models\Connection;

class KillsByMeans extends Connection {

	public $id_kills_by_means;
	public $name;
	public $id_game;
	public $total;

	protected $object = "\App\Models\KillsByMeans";
	protected $table = "kills_by_means";
	protected $key = "id_kills_by_means";

	public function __construct() {
		parent::__construct();
		$this->execute();
	}

	private function execute() {
		$this->conn->query("
			CREATE TABLE IF NOT EXISTS quake_log_parser.kills_by_means (
				id_kills_by_means 	INT(11) NOT NULL AUTO_INCREMENT,
				name 				VARCHAR(45) NOT NULL,
				id_game 			INT(11) NOT NULL,
				total	 			INT(11) NOT NULL,

				PRIMARY KEY (id_kills_by_means),
					INDEX fk_kills_by_means_game_idx (id_game ASC),

				CONSTRAINT fk_kills_by_means_game
					FOREIGN KEY (id_game)
					REFERENCES quake_log_parser.game (id_game)
						ON DELETE NO ACTION
						ON UPDATE NO ACTION
			) ENGINE = InnoDB DEFAULT CHARACTER SET = utf8;
		");
	}

	public function save() {
		$this->columns = [
			'name' => $this->name,
			'id_game' => $this->id_game,
			'total' => $this->total
		];

		if($this->find(['name' => $this->name, 'id_game' => $this->id_game])) {
			$this->update($this->id_kills_by_means);
			return $this;
		} else {
			$this->id_kills_by_means = parent::insert();
			return $this;
		}
	}

}