<?php
	
namespace App\Controller;

use App\Entity\LoginForm;
use App\Form\LoginController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class DownloadController extends AbstractController 
{   

    /**
     * Matches /downloadMod/*
     *
     * @Route("/downloadMod/{slug}", name="dw_show")
     */

    public function download($slug = null)
    {		
        if (isset($slug)) {

            $sql = 'SELECT * FROM "modScheme"."mod" WHERE "id" = :id';
            $em = $this->getDoctrine()->getManager();
            $stmt1 = $em->getConnection()->prepare($sql);
            $stmt1->execute(['id' => $slug]);
            $result = $stmt1->fetchAll();

            if (!empty($result)) {
                /* just do the Login fomr controller */
        		$task = new LoginForm();
        		$task->setLoginEmail('');
        		$task->setPasswordInput('');
                $useResult = $result[0];
                
                $sql1 = 'UPDATE "modScheme"."mod" SET "downloads" = "downloads" + 1 WHERE "id" = :id';
                $em1 = $this->getDoctrine()->getManager();
                $stmt11 = $em1->getConnection()->prepare($sql1);
                $stmt11->execute(['id' => $slug]);
                //$result1 = $stmt11->fetchAll();
                
    	    	//$task = 'fdshjfdsn';
    	    	$form = $this->createForm(LoginController::class, $task);
                return $this->render('beam/download.html', array('form' => $form->createView(), 'file' => $useResult));
        }   else {
            return new Response('404');
        }
        } else {
            return new Response('404');
        }
    }
}

?>