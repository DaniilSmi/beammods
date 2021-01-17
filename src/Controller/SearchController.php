<?php
	
	namespace App\Controller;

	use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
	use App\Entity\Product;
	use Doctrine\ORM\EntityManagerInterface;
	use Symfony\Component\HttpFoundation\JsonResponse;
	use Symfony\Component\HttpFoundation\Response;

	class SearchController extends AbstractController 
{
    public function getInfo()
    {	

    	// get the data for select
    	$sql = $_GET['query'];

	    $em = $this->getDoctrine()->getManager();
	    $stmt = $em->getConnection()->prepare($sql);
	    $stmt->execute();
	    $result = $stmt->fetchAll();
	    // add comments value
	    foreach ($result as $k => $v) {
	    	$sql45 = 'SELECT COUNT(*) FROM "modScheme"."comments" WHERE "mod_id" = :modId';

		    $em45 = $this->getDoctrine()->getManager();
		    $stmt45 = $em45->getConnection()->prepare($sql45);
		    $stmt45->execute(["modId" => $result[$k]['id']]);
		    $result45 = $stmt45->fetchAll();

	    	$result[$k]['comments'] = $result45[0]['count'];
	    }

	    // create response	
    	$response = new Response(json_encode($result, true));
    	$response->send();
    }
}
?>	