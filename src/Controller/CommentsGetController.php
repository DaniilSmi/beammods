<?php
	
namespace App\Controller;

use App\Entity\LoginForm;
use App\Form\LoginController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;

class CommentsGetController extends AbstractController 
{
    public function getComment()
    {		
            /* just do the Login fomr controller */
    		/*$task = new LoginForm();
    		$task->setLoginEmail('');
    		$task->setPasswordInput('');

            $sql = 'SELECT * FROM "SomePages"."indexPage" WHERE "id" = 1';
            $em = $this->getDoctrine()->getManager();
            $stmt1 = $em->getConnection()->prepare($sql);
            $stmt1->execute();
            $result = $stmt1->fetchAll()[0];
            
	    	//$task = 'fdshjfdsn';
	    	$form = $this->createForm(LoginController::class, $task);
        return $this->render('beam/index.html', array('form' => $form->createView(), 'result' => $result));*/

        $commentsGetPage = $_GET['page'];

        $sql = 'SELECT * FROM "modScheme"."comments" WHERE "mod_id" = :id ORDER BY "parent_id", "isAnswer", "id"';
        $em = $this->getDoctrine()->getManager();
        $stmt1 = $em->getConnection()->prepare($sql);
        $stmt1->execute(['id' => $commentsGetPage]);
        $result = $stmt1->fetchAll();

        $result = json_encode($result, true);
        

        return new Response($result);
    }
}

?>