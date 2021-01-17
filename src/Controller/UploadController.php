<?php
	
namespace App\Controller;

use App\Entity\LoginForm;
use App\Form\LoginController;
use App\Entity\ProfileImageForm;
use App\Form\ProfileImageFormController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Session\Session;

class UploadController extends AbstractController 
{
    // function for upload file from ajax
    public function uploadFile(Request $request)    {
      $session = new Session();
      $session->start();
      
    // get the file from request
    $file = $request->files->get('img');

    // set status for ajax validate
    $status = array('status' => "success","fileUploaded" => false);
    // create new form class
    $task = new ProfileImageForm();
    // create new form
    $form = $this->createForm(ProfileImageFormController::class, $task);
   // If a file was uploaded
   if(!is_null($file)){
        // set class value and get it
        $task->setImage($file);
        $file2 = $task->getImage();
      // generate a random name for the file but keep the extension
        $filename = uniqid().".".$file2->getClientOriginalExtension();
        // upload file

        // allowed file types
        $allowed = array('gif', 'png', 'jpg', 'jpeg', 'svg');
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if (in_array($ext, $allowed)) {
            $file2->move(
                $this->getParameter('img'),
                $filename
            );
        
        
        // get user id and old imageName for delete it
        $userId = $session->get('logged_user')['id'];
        $getOldFile = $session->get('logged_user')['imageName'];

        // if file exist - delete it
        if (file_exists($this->getParameter('img').$getOldFile)) {
          if ($getOldFile != 'defaultUserImg.png') {
             unlink($this->getParameter('img').$getOldFile);
          }
        }
        // update user
        $sql = 'UPDATE "User"."user" SET "imageName" = :image WHERE "id" = :id';
        $em = $this->getDoctrine()->getManager();
        $stmt1 = $em->getConnection()->prepare($sql);
        $stmt1->execute(['id' => $userId, 'image' => $filename]);
        
        // select new  updated user
        $sql2 = 'SELECT * FROM "User"."user" WHERE "id" = :id';
        $em2 = $this->getDoctrine()->getManager();
        $stmt12 = $em->getConnection()->prepare($sql2);
        $stmt12->execute(['id' => $userId]);
        $result = $stmt12->fetchAll();
        // set new session
        $session->set('logged_user', $result[0]);
    // set starus for ajax
      $status = array('status' => "success","fileUploaded" => $filename);
    }
   }

   // return status
   return new JsonResponse($status);
}
}

?>