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

	/* controller for show the register page and its form */

	class RegisterPageController extends AbstractController
	{
		public function getPage(Request $request) {

			// create new login form controller
			$task = new LoginForm();
			//set null data
    	$task->setLoginEmail('');
    	$task->setPasswordInput('');
    	// create new register form class
    	$task2 = new RegisterForm();
    	$post = new RegisterForm();
    	// create form
    	$form2 = $this->createForm(RegisterController::class, $task2, array());
    	// get request
    	$form2->handleRequest($request);
    	// set null data for error
    	$errorFinally = '';
        if ($form2->isSubmitted() && $form2->isValid()) {
        		// get Array from request
        		$useData = $request->request->all();

        		// set all the data to form from request
            $post->setEmail($useData['register_controller']['email']);
            $post->setLogin($useData['register_controller']['login']);
            $post->setPassword1($useData['register_controller']['password1']);
            $post->setPassword2($useData['register_controller']['password2']);
            
            // validate data
            // get data
            $sql = 'SELECT * FROM "User"."user" WHERE "login" = :login';
				    $em = $this->getDoctrine()->getManager();
				    $stmt1 = $em->getConnection()->prepare($sql);
				    $stmt1->execute(['login' => $post->getLogin()]);
				    $result = $stmt1->fetchAll();

				    // get data
				    $sql2 = 'SELECT * FROM "User"."user" WHERE "email" = :email';
				    $stmt2 = $em->getConnection()->prepare($sql2);
				    $stmt2->execute(['email' => $post->getEmail()]);
				    $result2 = $stmt2->fetchAll();

				    $error = array();
				    // throw the login error
				    if (!empty($result)) {
				    	$error[] = 'Пользователь с таким логином уже существует!';
				    }

				    // throw thr email error
				    if (!empty($result2)) {
				    	$error[] = 'Пользователь с таким email уже существует!';
				    }
				    // throw the password error
				    if ($post->getPassword1() != $post->getPassword2()) {
				    	$error[] = 'Пароли не совпадают!';
				    }
            
            // register user
            if (empty($error)) {
            	// create user 
            	$sql3 = 'INSERT INTO "User"."user" ("login", "email", "password", "imageName") VALUES (:login, :email, :password, :image)';
					    $stmt3 = $em->getConnection()->prepare($sql3);
					    $stmt3->execute(['login' => $post->getLogin(),'email' => $post->getEmail(), 'password' => password_hash($post->getPassword1(), PASSWORD_DEFAULT), 'image' => "defaultUserImg.png"]);
					    echo "<script>let a = alert('Войдите в аккаунт!');

								window.location.href = 'http://beammods.ru/';
							</script>";
            } else {
            	// get the first array value
            	$errorFinally =  "<div style='color:red; font-size:15px;'>".array_shift($error)."</div>";
            }
        }
	    $form = $this->createForm(LoginController::class, $task);
      return $this->render('beam/register.html', array('form' => $form->createView(), 'form2' => $form2->createView(), 'error' => $errorFinally));
		}
	}
?>