<?php
	namespace App\Controller;

	use Symfony\Component\HttpFoundation\Session\Session;
	use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\HttpFoundation\Response;
	
	class LogoutController extends AbstractController
	{
		public function logout() {

			// delete user session
			$session = new Session;
			$session->start();
			$session->remove('logged_user');

			return $this->redirectToRoute('index');
		}
	}
?>