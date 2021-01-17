<?php
	namespace App\Entity;

	class NewPasswordForm
	{
		protected $password1;
		protected $password2;

		public function setPassword1($password1) {
			$this->password1 = $password1;
		}

		public function getPassword1() {
			return $this->password1;
		}

		public function setPassword2($password2) {
			$this->password2 = $password2;
		}

		public function getPassword2() {
			return $this->password2;
		}
	}
?>