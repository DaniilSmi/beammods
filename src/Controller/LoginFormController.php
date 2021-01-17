<?php
	namespace App\Controller;

	use App\Entity\LoginForm;
	use App\Entity\RegisterForm;
	use App\Form\LoginController;
	use App\Form\RegisterController;
	use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
	use App\Entity\Product;
	use Doctrine\ORM\EntityManagerInterface;
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\HttpFoundation\Response;
	use Symfony\Component\HttpFoundation\Session\Session;
	/* controller for show the register page and its form */

	class LoginFormController extends AbstractController
	{
		public function getData(Request $request) {
			// creating new form
			$task2 = new LoginForm();
    	$form2 = $this->createForm(LoginController::class, $task2, array());
    	// get the request
    	$form2->handleRequest($request);

    	// validate form
    	if ($form2->isSubmitted() && $form2->isValid()) {
    		// get request data and paste data to controller class
    		$useData = $request->request->all();
	    	$task2->setLoginEmail($useData['login_controller']['loginEmail']);
	      $task2->setPasswordInput($useData['login_controller']['passwordInput']);

	      // get the user
	     	$sql = 'SELECT * FROM "User"."user" WHERE "login" = :login OR "email" = :login';
				$em = $this->getDoctrine()->getManager();
				$stmt1 = $em->getConnection()->prepare($sql);
				$stmt1->execute(['login' => $task2->getLoginEmail()]);
				$result = $stmt1->fetchAll();
				$error = array();
	      //validate data

				// validate data
				if (!empty($result)){
					if (!password_verify($task2->getPasswordInput(), $result[0]['password'])) {
		      	$error[] = 'Неверный пароль!';
		      }
				} else {
					$error[] = 'Неверный логин или email';
				}


				// login user
				if (empty($error)) {

					// start new sesion 
					$session = new Session();
					$session->start();
					$session->set('logged_user', $result[0]);
					
					// redirect to index page
					return $this->redirectToRoute('index');
				} else{
					echo "<script> alert('".array_shift($error)."'); window.location.href = 'http://beammods.ru/' </script>";
				}
 			}
    return new Response('');
	}
}
?>