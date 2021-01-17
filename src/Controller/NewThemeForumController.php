<?php
	
namespace App\Controller;

use App\Entity\LoginForm;
use App\Form\LoginController;
use App\Entity\NewThemeForm;
use App\Form\NewThemeFormController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class NewThemeForumController extends AbstractController 
{
    public function make(Request $request)
    {		
            /* just do the Login fomr controller */
    		$task = new LoginForm();
    		$task->setLoginEmail('');
    		$task->setPasswordInput('');

            $task2 = new NewThemeForm();

            
	    	//$task = 'fdshjfdsn';
	    	$form = $this->createForm(LoginController::class, $task);
            $form2 = $this->createForm(NewThemeFormController::class, $task2);

            $form2->handleRequest($request);

            $session = new Session;
            $session->start();
            //$session->remove('logged_user');
            $sessionResult45 = $session->get("logged_user");

            if ($form2->isSubmitted() && $form2->isValid()) {
                if (!empty($sessionResult45)) {
                    $useData = $request->request->all()['new_theme_form_controller'];
                    $task2->setTheme($useData['theme']);
                    $task2->setSubTheme($useData['subTheme']);

                    

                    $sql = 'INSERT INTO "forum"."forumtheme" ("title", "subtitle", "theme_author") VALUES (:title, :subtitle, :author)';
                    $em = $this->getDoctrine()->getManager();
                    $stmt1 = $em->getConnection()->prepare($sql);
                    $stmt1->execute(['title' => $task2->getTheme(), 'subtitle' => $task2->getSubTheme(),'author' => $sessionResult45['login']]);
                    
                    return $this->redirectToRoute('forum');
                }
            }

        return $this->render('beam/newTheme.html', array('form' => $form->createView(), 'form2' => $form2->createView()));
    }
}

?>