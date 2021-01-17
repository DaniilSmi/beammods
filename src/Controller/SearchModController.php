<?php
	
namespace App\Controller;

use App\Entity\LoginForm;
use App\Form\LoginController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class SearchModController extends AbstractController 
{   

    /**
     * Matches /searchMod/*
     *
     * @Route("/searchMod/q/{slug}", name="srm_show")
     */

    public function search($slug = null)
    {		
        if (isset($slug)) {
            $sqlF = 'select * from "modScheme"."mod" where title % `'.$slug.'`';
            $sql = 'select * from "modScheme"."mod" where title % :textL';
            $em = $this->getDoctrine()->getManager();
            $stmt1 = $em->getConnection()->prepare($sql);
            $stmt1->execute(['textL' => $slug]);
            $result = $stmt1->fetchAll();

            if (!empty($result)) {
                /* just do the Login fomr controller */
        		$task = new LoginForm();
        		$task->setLoginEmail('');
        		$task->setPasswordInput('');
                $useResult = $result[0];
                

                $sql2 = 'select count(*) from "modScheme"."mod" where title % :textL';
                $em2 = $this->getDoctrine()->getManager();
                $stmt12 = $em2->getConnection()->prepare($sql2);
                $stmt12->execute(['textL' => $slug]);
                $result2 = $stmt12->fetchAll()[0]['count'];
                
    	    	//$task = 'fdshjfdsn';
    	    	$form = $this->createForm(LoginController::class, $task);



                return $this->render('beam/search.html', array('form' => $form->createView(), 'file' => $useResult, 'slug' => $slug, 'find' => $result2, 'sql' => $sqlF));

        }   else {
            return new Response('Ничего не найдено((');
        }
        } else {
            return new Response('404');
        }
    }
}

?>