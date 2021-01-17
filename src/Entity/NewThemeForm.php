<?php
	namespace App\Entity;


	class NewThemeForm
	{
		protected $theme;
		protected $subTheme;

		public function setTheme($theme) {
			$this->theme = $theme;
		}

		public function getTheme() {
			return $this->theme;
		}

		public function setSubTheme($subTheme) {
			$this->subTheme = $subTheme;
		}

		public function getSubTheme() {
			return $this->subTheme;
		}
	}

?>