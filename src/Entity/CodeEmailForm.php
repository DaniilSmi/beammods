<?php
	namespace App\Entity;

	class CodeEmailForm
	{
		protected $code;

		public function setCode($code) {
			$this->code = $code;
		}

		public function getCode() {
			return $this->code;
		}
	}
?>