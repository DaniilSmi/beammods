<?php
	namespace App\Entity;

	class EmailResetForm
	{
		protected $email;

		public function setEmail($email) {
			$this->email = $email;
		}

		public function getEmail() {
			return $this->email;
		}
	}

?>