<?php
	
namespace App\Controller;

use App\Entity\LoginForm;
use App\Form\LoginController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\Session;

class AddmodController extends AbstractController 
{
    public function show()
    {		
            /* just do the Login fomr controller */
    		$task = new LoginForm();
    		$task->setLoginEmail('');
    		$task->setPasswordInput('');
            // get
            
            $arr = array();


            $session = new Session();
            $session->start();
            $sessionResult = $session->get("logged_user");
            if (!empty($sessionResult)) {
                if (isset($_POST['submitAddMod'])) {
                    foreach ($_FILES['files']['name'] as $key => $value) {
                       $id = uniqid();
                        if ($key < 4) {
                            $arr[$key] = $id.$_FILES['files']['name'][$key];
                            $allowed = array('gif', 'png', 'jpg', 'jpeg', 'svg');
                            $ext = pathinfo($_FILES['files']['name'][$key], PATHINFO_EXTENSION);
                            if (in_array($ext, $allowed)) {
                                 move_uploaded_file($_FILES['files']['tmp_name'][$key], $this->getParameter('mod').$id.$_FILES['files']['name'][$key]);
                            }
                        }
                    }

                    $id = uniqid();

                    $allowed = array('zip', '7zip', 'rar');
                    $ext = pathinfo($_FILES['mod']['name'], PATHINFO_EXTENSION);
                    $modName = $id.$_FILES['mod']['name'];
                    if (in_array($ext, $allowed)) {
                         move_uploaded_file($_FILES['mod']['tmp_name'], $this->getParameter('modFile').$id.$_FILES['mod']['name']);
                    }

                    $json_array = json_encode($arr, true);
                    $drw = false;


                    
                        
                    
                    //mb_strtoupper() 

                    $size = $_FILES['mod']['size'];
                    $size =  round($size / 1000000, 1);
                    $date = date("H:i d.m.Y");
                    if (isset($_POST['drwheelAddmod'])) {
                        $sql1 = 'INSERT INTO "modScheme"."mod" ("title", "user_loader_name", "date_time", "author", "brand", "body_type", "drive_init", "driving_wheel", "imagesArray", "textAbout", "modSize", "modFile") VALUES (:title, :user_loader_name, :date_time, :author, :brand, :body_type, :drive_init, :driving_wheel, :imagesArray, :textAbout, :modSize, :modFile)';
                        $em1 = $this->getDoctrine()->getManager();
                        $stmt11 = $em1->getConnection()->prepare($sql1);
                        $stmt11->execute(['title' => $_POST['titleAddmod'], 'user_loader_name' => $sessionResult['login'], 'date_time' => $date, 'author' => $_POST['authorAddmod'], 'brand' => $_POST['brandAddmod'], 'body_type' => $_POST['btAddmod'], 'drive_init' => $_POST['diAddmod'], "driving_wheel" => true, 'imagesArray' => $json_array, 'textAbout' => $_POST['addmodArea'], 'modSize' => $size, "modFile" => $modName]);
                        $result1 = $stmt11->fetchAll()[0];
                     } else {
                        $sql1 = 'INSERT INTO "modScheme"."mod" ("title", "user_loader_name", "date_time", "author", "brand", "body_type", "drive_init", "imagesArray", "textAbout", "modSize", "modFile") VALUES (:title, :user_loader_name, :date_time, :author, :brand, :body_type, :drive_init,  :imagesArray, :textAbout, :modSize, :modFile)';
                        $em1 = $this->getDoctrine()->getManager();
                        $stmt11 = $em1->getConnection()->prepare($sql1);
                        $stmt11->execute(['title' => mb_strtoupper($_POST['titleAddmod']), 'user_loader_name' => $sessionResult['login'], 'date_time' => $date, 'author' => $_POST['authorAddmod'], 'brand' => $_POST['brandAddmod'], 'body_type' => $_POST['btAddmod'], 'drive_init' => $_POST['diAddmod'], 'imagesArray' => $json_array, 'textAbout' => $_POST['addmodArea'], 'modSize' => $size, "modFile" => $modName]);
                        $result1 = $stmt11->fetchAll()[0];
                     }
                }
            }
	    	//$task = 'fdshjfdsn';
	    	$form = $this->createForm(LoginController::class, $task);
        return $this->render('beam/addmod.html', array('form' => $form->createView()));
    }
}

?>