<?php
	
	namespace App\Entity;

	class CommentForm 
	{
		protected $text;

		public function setText($text) {
			$this->text = $text;
		}

		public function getText() {
			return $this->text;
		}
	}

?>