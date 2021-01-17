<?php
	
namespace App\Controller;

use App\Entity\LoginForm;
use App\Form\LoginController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\CommentForm;
use App\Form\CommentFormController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;


class InfileController extends AbstractController 
{

     /**
     * Matches /mod/*
     *
     * @Route("/mod/{slug}", name="mod_show")
     */

    public function getPage($slug = null, Request $request)
    {		

        if (isset($slug)) {
        



        /**/
        $task78 = new CommentForm();
        $form78 = $this->createForm(CommentFormController::class, $task78);
        // get request
        $form78->handleRequest($request);
        // check request results
        if ($form78->isSubmitted() && $form78->isValid()) {
            $useData = $request->request->all();
            $task78->setText(htmlspecialchars($useData['comment_form_controller']['text']));

            // set styles
            $text = str_replace("[bigtext]", '<b>', $task78->getText());
            $text = str_replace("[bigtext/]", '</b>', $text);
            $text = str_replace("[italictext]", '<i>', $text);
            $text = str_replace("[italictext/]", '</i>', $text);

            // get name
           $text2 = stristr($text, ']', true);
           $text2 = stristr($text2, 'name/', true);
           $textName = str_replace('[quote', '', $text2);
           // name
           $textName = str_replace('[name', '', $textName);

           // get id 
           $text3 = stristr($text, 'commentId/]', true);
           $text3 = stristr($text3, '[commentId');
           // id 
           $textCId = str_replace('[commentId', '', $text3);
            $session = new Session;
            $session->start();
            //$session->remove('logged_user');
            $sessionResult45 = $session->get("logged_user");
            $textFinal = stristr($text, ']');
            $textFinal = stristr($textFinal, 'commentId/]');
            $textFinal = str_replace('commentId/]]', '', $textFinal);
            $textFinal2 = $text;
            if (isset($sessionResult45)) {
               if (!empty($textName) && !empty($textCId)) {
                $sqlN = 'INSERT INTO "modScheme"."comments" ("mod_id", "user_name", "datetime", "text", "img_url", "isAnswer", "user_id", "parent_id") VALUES (:mod_id, :user_name, :datetime1, :text4, :img_url, :isAnswer, :user_id, :parent_id)';
                $emN = $this->getDoctrine()->getManager();
                $stmt1N = $emN->getConnection()->prepare($sqlN);
                $stmt1N->execute(['mod_id' => $slug, "user_name" => $sessionResult45['login'], "datetime1" => date("H:i d.m.Y"), "text4" => $textName.', '.$textFinal, "img_url" => $sessionResult45['imageName'], "isAnswer" => true, "user_id" => $sessionResult45['id'], "parent_id" => $textCId]);
                //$result = $stmt1N->fetchAll();
               } else {
                $sqlNn = 'INSERT INTO "modScheme"."comments" ("mod_id", "user_name", "datetime", "text", "img_url", "user_id") VALUES (:mod_id, :user_name, :datetime1, :text4, :img_url, :user_id)';
                $emNn = $this->getDoctrine()->getManager();
                $stmt1Nn = $emNn->getConnection()->prepare($sqlNn);
                $stmt1Nn->execute(['mod_id' => $slug, "user_name" => $sessionResult45['login'], "datetime1" => date("H:i d.m.Y"), "text4" => $textFinal2, "img_url" => $sessionResult45['imageName'], "user_id" => $sessionResult45['id']]);
                //$result = $stmt1Nn->fetchAll();
               }
            } else {
                $error[] = "Вы не авторизованы!";
                echo "<script> alert('".array_shift($error)."'); </script>";
            }
        }    

        /**/    
        $sql = 'SELECT * FROM "modScheme"."mod" WHERE "id" = :id';
        $em = $this->getDoctrine()->getManager();
        $stmt1 = $em->getConnection()->prepare($sql);
        $stmt1->execute(['id' => $slug]);
        $result = $stmt1->fetchAll();

        // get likes

        $sql45 = 'SELECT COUNT(*) FROM "modScheme"."likes" WHERE "mod_id" = :id';
        $em45 = $this->getDoctrine()->getManager();
        $stmt145 = $em45->getConnection()->prepare($sql45);
        $stmt145->execute(['id' => $slug]);
        $result4545 = $stmt145->fetchAll()[0]['count'];

        // set new view
        $sql4545 = 'UPDATE "modScheme"."mod" SET "watches" = "watches" + 1 WHERE "id" = :id';
        $em4545 = $this->getDoctrine()->getManager();
        $stmt14545 = $em4545->getConnection()->prepare($sql4545);
        $stmt14545->execute(['id' => $slug]);
        //$result454545 = $stmt14545->fetchAll()[0]['count'];


        if (!empty($result)) {
            $result = $result[0];

            $task = new LoginForm();
            $commTask = new CommentForm();
            $form = $this->createForm(LoginController::class, $task);
            $commForm = $this->createForm(CommentFormController::class, $commTask);

            //echo json_encode("[{'1' => 'image.png'}]", true);
            $scriptImg = "<script>showImages(".json_encode($result['imagesArray'], true).")</script>";
            $script2 = "<script>getComments(".$slug.") </script>";

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $useData = $request->request->all();
                $commTask->setText($useData['comment_form_controller_text']['text']);
                echo $useData;
            }

            $textLike = str_replace(' ', '%', $result['title']); 

            $sqlLike = 'select * from "modScheme"."mod" where title % :textL order by id LIMIT 8';
            $emLike = $this->getDoctrine()->getManager();
            $stmt1Like = $emLike->getConnection()->prepare($sqlLike);
            $stmt1Like->execute(['textL' => $textLike]);
            $resultLike = $stmt1Like->fetchAll();

            foreach ($resultLike as $key => $value) {
                $resultLike[$key]['fim'] = json_decode($resultLike[$key]['imagesArray'])[0]; 
            }

            return $this->render('beam/infile.html', array('form' => $form->createView(), 'file' => $result, 'scriptImg' => $scriptImg, 'likes' => $result4545, 'script2' => $script2, 'commForm' => $commForm->createView(), 'resultL' => $resultLike));
        } else  {
            return new Response('404');
        }
    
        } else {
            return new Response('404');
        }
    }
}

?>