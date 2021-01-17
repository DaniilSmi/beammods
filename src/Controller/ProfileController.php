<?php
	namespace App\Controller;

	use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
	use App\Entity\LoginForm;
	use App\Form\LoginController;
	use App\Entity\ProfileInfoForm;
	use App\Form\ProfileInfoFormController;
	use Symfony\Component\HttpFoundation\Session\Session;
	use Symfony\Component\HttpFoundation\Request;
	use Doctrine\ORM\EntityManagerInterface;

	class ProfileController extends AbstractController
	{
		public function getProfilePage(Request $request){
			// create new login form class
			$task = new LoginForm();
			// create new profile form inforamtion class
			$profileTask = new ProfileInfoForm();
			// get the logged_user session
			$session = new Session();
			$session->start();
			$sessionResult =  $session->get('logged_user');
			if (isset($sessionResult)) {
			// set defaults for form information and detete tabs
			$profileTask->setLogin(trim($sessionResult['login']));
			$profileTask->setEmail(trim($sessionResult['email']));

			// set null data
    	$task->setLoginEmail('');
    	$task->setPasswordInput('');
    	}
    	// create login form
	    $form = $this->createForm(LoginController::class, $task);
	    // create profile form
	    $profileInfoForm = $this->createForm(ProfileInfoFormController::class, $profileTask, array());
	    // get request
	    $profileInfoForm->handleRequest($request);
	    // if form correct
	    if ($profileInfoForm->isSubmitted() && $profileInfoForm->isValid()) {
	    	// get the data from request
	    	$useData = $request->request->all()['profile_info_form_controller'];
	    	// $useData['profile_info_form_controller']['login'];

	    	// save the data from request to controller class
	    	$profileTask->setLogin($useData['login']);
	    	$profileTask->setEmail($useData['email']);
	    	$profileTask->setPassword($useData['password']);
	    	$error = array();

	    	// get the people with this login
	    		$sql45 = 'SELECT * FROM "User"."user" WHERE "email" = :email OR "login" = :login'; 
		    	$em45 = $this->getDoctrine()->getManager();
			    $stmt45 = $em45->getConnection()->prepare($sql45);
			    $stmt45->execute(['email' => $profileTask->getEmail(), 'login' => $profileTask->getLogin()]);
			    $result45 = $stmt45->fetchAll();

			    	// validate array
					for ($i=0; $i<$result45; $i++) {
						if ($result45[$i]['id'] == $sessionResult['id']) {
				    	unset($result45[$i]);
				    	break;
				    }		
					}
	    	// update the user data 
	    	$userPassword = $sessionResult['password'];
	    	// check password
	    	if (empty($result45)) {
		    	if (password_verify($profileTask->getPassword(), $userPassword)) {
			    	$sql = 'UPDATE "User"."user" SET "login" = :login, "email" = :email WHERE "id" = :id'; 
			    	$em = $this->getDoctrine()->getManager();
				    $stmt = $em->getConnection()->prepare($sql);
				    $stmt->execute(['login' => $profileTask->getLogin(), 'email' => $profileTask->getEmail(), 'id' => $sessionResult['id']]);
				    // redirect user
				    return $this->redirectToRoute('logout');
		    	} else {
		    		// set error
		    		$error[] = "Неверный пароль!";
		    	}
		    } else {
		    	$error[] = "Пользователь с таким логином или email уже существует!";
		    }

	    }
	    // if error isset - throw error
	    if (!empty($error)) {
	    	echo "<script>alert('".array_shift($error)."')</script>";
	    }

	    // create views for forms and show template
			return $this->render('beam/profile.html', array('form' => $form->createView(), 'profileForm' => $profileInfoForm->createView()));
		
		}

	}
?>