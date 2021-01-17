<?php
	
namespace App\Controller;

use App\Entity\LoginForm;
use App\Form\LoginController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;

class DefaultController extends AbstractController 
{
    public function index()
    {		
            /* just do the Login fomr controller */
    		$task = new LoginForm();
    		$task->setLoginEmail('');
    		$task->setPasswordInput('');

            $sql = 'SELECT * FROM "SomePages"."indexPage" WHERE "id" = 1';
            $em = $this->getDoctrine()->getManager();
            $stmt1 = $em->getConnection()->prepare($sql);
            $stmt1->execute();
            $result = $stmt1->fetchAll()[0];
            
	    	//$task = 'fdshjfdsn';
	    	$form = $this->createForm(LoginController::class, $task);
        return $this->render('beam/index.html', array('form' => $form->createView(), 'result' => $result));
    }
}

?>