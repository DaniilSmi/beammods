<?php
	
	namespace App\Controller;

	use App\Entity\LoginForm;
	use App\Form\LoginController;
	use App\Entity\NewPasswordForm;
	use App\Form\NewPasswordFormController;
	use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
	use App\Entity\Product;
	use Doctrine\ORM\EntityManagerInterface;
	use App\Entity\EmailResetForm;
	use App\Form\EmailResetFormController;
	use App\Entity\CodeEmailForm;
	use App\Form\CodeEmailFormController;
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\HttpFoundation\Cookie;

	class ResetController extends AbstractController
	{
		

		public function getResetPage (Request $request, \Swift_Mailer $mailer) {
			// create new forms controllers
			$task = new LoginForm();
			$emailTask = new EmailResetForm();
			$codeTask = new CodeEmailForm();
			$script = '';
			// create new forms
	    $form = $this->createForm(LoginController::class, $task);
	    $resetForm = $this->createForm(EmailResetFormController::class, $emailTask);
	    $codeForm = $this->createForm(CodeEmailFormController::class, $codeTask);

	    /*//////////////////////*/
	    /* get the data request */
	    /*//////////////////////*/

	    // get the resetForm request
	    $resetForm->handleRequest($request);

	    // check form
	    if ($resetForm->isSubmitted() && $resetForm->isValid()) {

	    	// get the request data
	    	$userData1 = $request->request->all()['email_reset_form_controller'];

	    	// set the data t controller
	    	$emailTask->setEmail($userData1['email']);

	    	$rand = mt_rand(000000, 999999);

	    	$cookieData = password_hash($rand, PASSWORD_DEFAULT);
	    	setcookie('dataCode', $cookieData, time() + 1200);
	    	setcookie('resetEmail', $emailTask->getEmail(), time() + 1200);


	    	$message = (new \Swift_Message('Code for beammods.ru'))
        ->setFrom('send@beammods.ru')
        ->setTo($emailTask->getEmail())
        ->setBody(
            $this->renderView(
                // templates/emails/registration.html.twig
                'emails/codeEmail.html',
                array('code' => $rand)
            ),
            'text/html'
        );

        $mailer->send($message);
	    	$script = "<script>window.onload = function() {document.querySelector('.pageText').style.transform = 'translateY(0px)'; document.querySelector('body').style.overflow = 'hidden';}</script>";

	    }	

	    // get the code form request

	    $codeForm->handleRequest($request);

	    if ($codeForm->isSubmitted() && $codeForm->isValid()) {
	    	// get the request data
	    	$userData2 = $request->request->all()['code_email_form_controller'];
	    	// set the request data to controller
	    	$codeTask->setCode($userData2['code']);

	    	// varify code
	    	if (password_verify($codeTask->getCode(), $_COOKIE['dataCode'])) {
	    		$newTaskForm22 = new NewPasswordForm();

	    		$form22 = $this->createForm(NewPasswordFormController::class, $newTaskForm22);

	    		return $this->render('beam/resetPage2.html', array('form' => $form->createView(), 'form2' => $form22->createView()));
	    	}
	    }

			return $this->render('beam/resetPage.html', array('form' => $form->createView(), 'form2' => $resetForm->createView(), 'form3' => $codeForm->createView(), 'script' => $script));
		} 
	}

?>