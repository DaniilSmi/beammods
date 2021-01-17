<?php
	
	namespace App\Controller;

	use App\Entity\NewPasswordForm;
	use App\Form\NewPasswordFormController;
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\HttpFoundation\Response;
	use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
	use Doctrine\ORM\EntityManagerInterface;

	class ResetPage2Controller extends AbstractController
	{
		

		public function getResetPage (Request $request) {

			// create form class
			$task = new NewPasswordForm();
			// create form
			$form = $this->createForm(NewPasswordFormController::class, $task);

			$form->handleRequest($request);
			 if ($form->isSubmitted() && $form->isValid()) {
			 	$userData = $request->request->all()['new_password_form_controller'];

			 	$task->setPassword1($userData['password1']);
			 	$task->setPassword2($userData['password2']);

			 	if ($task->getPassword1() == $task->getPassword2()) {
			 		$userEmail = $_COOKIE['resetEmail'];

			 		$sql = 'UPDATE "User"."user" SET "password" = :password WHERE "email" = :email';
			    $em = $this->getDoctrine()->getManager();
			    $stmt = $em->getConnection()->prepare($sql);
			    $stmt->execute(['password' => password_hash($task->getPassword1(), PASSWORD_DEFAULT), 'email' => $userEmail]);
			    
			    setcookie('dataCode', '', time() -362148);
			    setcookie('resetEmail', '', time() -362148);
			    return $this->redirectToRoute('index');
			 	}
			 }

			 return new Response('<div style="color:red;">Пароли не совпадают</script>');
			//return $this->redirectToRoute('index');
		} 
	}

?>