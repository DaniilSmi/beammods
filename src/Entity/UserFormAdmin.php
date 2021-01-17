<?php
	namespace App\Entity;

	class UserFormAdmin
	{
		protected $id;
		protected $delete;

		public function setId($id) {
			$this->id = $id;
		}

		public function getId() {
			return $this->id;
		}

		public function setDelete($delete) {
			$this->delete = $delete;
		}

		public function getDelete() {
			return $this->delete;
		}
	}
?>