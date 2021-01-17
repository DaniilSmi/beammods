<?php
	
namespace App\Controller;

use App\Entity\LoginForm;
use App\Form\LoginController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;

class AboutusController extends AbstractController 
{
    public function show()
    {		
            /* just do the Login fomr controller */
    		$task = new LoginForm();
    		$task->setLoginEmail('');
    		$task->setPasswordInput('');

            $sql = 'SELECT * FROM "SomePages"."aboutUs" WHERE "id" = 1';
            $em = $this->getDoctrine()->getManager();
            $stmt1 = $em->getConnection()->prepare($sql);
            $stmt1->execute();
            $result = $stmt1->fetchAll()[0];
            
	    	//$task = 'fdshjfdsn';
	    	$form = $this->createForm(LoginController::class, $task);
        return $this->render('beam/about.html', array('form' => $form->createView(), 'info' => $result));
    }
}

?>