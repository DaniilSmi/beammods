<?php
	namespace App\Entity;

	class LoginForm
	{
	
		protected $loginEmail;
		protected $passwordInput;

		public function setLoginEmail(string $loginEmail): void {
			$this->loginEmail = $loginEmail;
		}

		public function getLoginEmail(): string {
			return $this->loginEmail;
		}


		public function setPasswordInput($passwordInput): void{
			$this->passwordInput = $passwordInput;
		}

		public function getPasswordInput(): string {
			return $this->passwordInput;
		}
	}
?>