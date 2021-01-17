<?php

	namespace App\Entity;


	class ProfileImageForm
	{
		protected $image;

		public function setImage($image){
			$this->image = $image;
		}

		public function getImage(){
			return $this->image;
		}
	}

?>