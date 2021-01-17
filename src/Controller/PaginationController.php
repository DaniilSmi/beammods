<?php
	namespace App\Controller;
	use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
	use Doctrine\EntityManagerInterface;
	use Symfony\Component\HttpFoundation\Response;

	class PaginationController extends AbstractController
	{
		function getInfoPagi(){
			// get the data for pagination
			$sql = 'SELECT COUNT(*) FROM "modScheme"."mod"';
	    $em = $this->getDoctrine()->getManager();
	    $stmt = $em->getConnection()->prepare($sql);
	    $stmt->execute();
	    $result = $stmt->fetchAll();
	    $result = $result[0]['count'];
	    $str = $result / 7;	
    	$response = new Response($str);
    	$response->send();
		}
	}
?>