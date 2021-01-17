<?php
	
	namespace App\Controller;

	use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
	use App\Entity\Product;
	use Doctrine\ORM\EntityManagerInterface;
	use Symfony\Component\HttpFoundation\JsonResponse;
	use Symfony\Component\HttpFoundation\Response;
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\HttpFoundation\Session\Session;

	class PostUrlController extends AbstractController 
{
    public function getInfo(Request $request)
    {	

    	$response45 = '';


    	// get the data for select
    	/*$sql = $request->request->all();
    	
    	print_r($sql);*/

    	$get = $_GET['query'];

    	$session = new Session;
			$session->start();
			$sessionResult = $session->get('logged_user');
			if (isset($sessionResult))  {
	    	if ($get == 1) {
	    		//$sql = 'UPDATE "modScheme"."mod" SET "likes" = "likes" + 1 WHERE "id" ='.$_GET['id'];
	    		$sql2 = 'SELECT * FROM "modScheme"."likes" WHERE "mod_id" = :modId AND "user_id" = :userId';
	    		$em2 = $this->getDoctrine()->getManager();
			    $stmt2 = $em2->getConnection()->prepare($sql2);
			    $stmt2->execute(['modId'=> $_GET['id'], "userId" => $sessionResult['id']]);
			    $resul2t = $stmt2->fetchAll();

			    if (!empty($resul2t)) {
			    	$sql = 'DELETE FROM "modScheme"."likes" WHERE "mod_id" ='.$_GET['id'].'AND "user_id" ='.$sessionResult['id'];
			    	$response45 = "m";
			    } else {
			    	$sql = $sql = 'INSERT INTO "modScheme"."likes" ("user_id", "mod_id") VALUES ('.$sessionResult['id'].','.$_GET['id'].')';
			    	$response45 = "p";
			    }
	    	}
			  $em = $this->getDoctrine()->getManager();
		    $stmt = $em->getConnection()->prepare($sql);
		    $stmt->execute();
		    $result = $stmt->fetchAll();
	  	} else {
	  		$response45 = 'Not auth';
	  	}
	    // create response	
    	$response = new Response($response45);
    	$response->send();
    }
}
?>