<?php
	namespace App\Entity;

	class RegisterForm
	{
	
		protected $login;
		protected $email;
		protected $password1;
		protected $password2;

		

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

		public function setPassword1($password1): void{
			$this->password1 = $password1;
		}

		public function getPassword1(): string {
			return $this->password1;
		}

		public function setPassword2($password2): void{
			$this->password2 = $password2;
		}

		public function getPassword2(): string {
			return $this->password2;
		}

		
	}
?>
