<?php
	namespace App\Entity;

	class ProfileInfoForm
	{
	
		protected $login;
		protected $email;
		protected $password;

	

		public function setLogin(string $login): void {
			$this->login = $login;
		}

		public function getLogin(): string {
			return $this->login;
		}

		

		public function setEmail(string $email): void {
			$this->email = $email;
		}

		public function getEmail(): string {
			return $this->email;
		}

		public function setPassword($password): void{
			$this->password = $password;
		}

		public function getPassword(): string {
			return $this->password;
		}

	

		
	}
?>