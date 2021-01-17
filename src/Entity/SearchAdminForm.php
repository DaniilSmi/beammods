<?php
	namespace App\Entity;

	class SearchAdminForm
	{
		protected $value;

		public function setValue($value) {
			$this->value = $value;
		}

		public function getValue() {
			return $this->value;
		}
		
	}
?>