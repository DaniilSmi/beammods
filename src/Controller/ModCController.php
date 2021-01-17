<?php
	namespace App\Controller;
	
	use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
	use Doctrine\EntityManagerInterface;
	use Symfony\Component\HttpFoundation\Response;

	class ModCController extends AbstractController
	{
		public function getInfo(){
			// get the data for pagination
			$sql = $_GET['query'];
	    $em = $this->getDoctrine()->getManager();
	    $stmt = $em->getConnection()->prepare($sql);
	    $stmt->execute();
	    $result = $stmt->fetchAll();
	    $result = $result[0]['count'];
	
    	$response = new Response($result);
    	$response->send();
		}
	}
?>