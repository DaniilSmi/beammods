<?php
	
namespace App\Controller;

use App\Entity\LoginForm;
use App\Form\LoginController;
use App\Entity\CommentForm;
use App\Form\CommentFormController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class ForumController extends AbstractController 
{   

    /**
     * Matches /forum/*
     *
     * @Route("/forum/{slug}/{page}", name="forum_show")
     */

    public function showForumPages($slug = null, $page = null, Request $request)
    {	
        $task = new LoginForm();
        $task->setLoginEmail('');
        $task->setPasswordInput('');
        $form = $this->createForm(LoginController::class, $task);

        if (!isset($slug)) {

                $sql = 'SELECT * FROM "forum"."forumtheme" ORDER BY "id" DESC';
                $em = $this->getDoctrine()->getManager();
                $stmt1 = $em->getConnection()->prepare($sql);
                $stmt1->execute();
                $result = $stmt1->fetchAll();

                
                
                
    	    	//$task = 'fdshjfdsn';
    	    	
                return $this->render('beam/forumIndex.html', array('form' => $form->createView(), 'theme' => $result));
        }   else {

            $sql1 = 'SELECT * FROM "forum"."forumtheme" WHERE "id" = :id LIMIT 1';
            $em1 = $this->getDoctrine()->getManager();
            $stmt11 = $em1->getConnection()->prepare($sql1);
            $stmt11->execute(['id' => $slug]);
            $result1 = $stmt11->fetchAll()[0];


            $sql77 = 'UPDATE "forum"."forumtheme" SET "views" = "views" + 1 WHERE "id" = :id';
            $em77 = $this->getDoctrine()->getManager();
            $stmt177 = $em77->getConnection()->prepare($sql77);
            $stmt177->execute(['id' => $slug]);

            if (!empty($result1)) {
                $task78 = new CommentForm();
                $form78 = $this->createForm(CommentFormController::class, $task78);
                $form78->handleRequest($request);

                $session = new Session;
                $session->start();
                //$session->remove('logged_user');
                $sessionResult45 = $session->get("logged_user");

                if ($form78->isSubmitted() && $form78->isValid()) {
                    /*if (isset($sessionResult45)) {

                    }*/

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
                //$session->start();
                //$session->remove('logged_user');
                $sessionResult45 = $session->get("logged_user");
                $textFinal = stristr($text, ']');
                $textFinal = stristr($textFinal, 'commentId/]');
                $textFinal = str_replace('commentId/]]', '', $textFinal);
                $textFinal2 = $text;

                $sql777 = 'UPDATE "forum"."forumtheme" SET "answers" = "answers" + 1 WHERE "id" = :id';
                $em777 = $this->getDoctrine()->getManager();
                $stmt1777 = $em777->getConnection()->prepare($sql777);
                $stmt1777->execute(['id' => $slug]);

                if (isset($sessionResult45)) {
                   if (!empty($textName) && !empty($textCId)) {
                    $sqlN = 'INSERT INTO "forum"."forumObj" ("theme_id", "user_name", "datetime", "text", "user_image", "isAnswer", "parent_id") VALUES (:theme_id, :user_name, :datetime1, :text4, :img_url, :isAnswer, :parent_id)';
                    $emN = $this->getDoctrine()->getManager();
                    $stmt1N = $emN->getConnection()->prepare($sqlN);
                    $stmt1N->execute(['theme_id' => $slug, "user_name" => $sessionResult45['login'], "datetime1" => date("H:i d.m.Y"), "text4" => $textName.', '.$textFinal, "img_url" => $sessionResult45['imageName'], "isAnswer" => true, "parent_id" => $textCId]);
                    //$result = $stmt1N->fetchAll();
                   } else {
                    $sqlNn = 'INSERT INTO "forum"."forumObj" ("theme_id", "user_name", "datetime", "text", "user_image") VALUES (:theme_id, :user_name, :datetime1, :text4, :img_url)';
                    $emNn = $this->getDoctrine()->getManager();
                    $stmt1Nn = $emNn->getConnection()->prepare($sqlNn);
                    $stmt1Nn->execute(['theme_id' => $slug, "user_name" => $sessionResult45['login'], "datetime1" => date("H:i d.m.Y"), "text4" => $text, "img_url" => $sessionResult45['imageName']]);
                   }
                } else {
                    $error[] = "Вы не авторизованы!";
                    echo "<script> alert('".array_shift($error)."'); </script>";
                }
                }

                $limit = 7;

                if (!isset($page)) {
                    $page = 1;
                    $offset = 0;
                } else {
                    $offset = ($page - 1) * 7;
                }

                $sql = 'SELECT * FROM "forum"."forumObj" WHERE "theme_id" = :id LIMIT :limit1 OFFSET :offset1';
                $em = $this->getDoctrine()->getManager();
                $stmt1 = $em->getConnection()->prepare($sql);
                $stmt1->execute(['id' => $slug, 'limit1' => $limit, 'offset1' => $offset]);
                $result = $stmt1->fetchAll();

                $sql = 'SELECT COUNT(*) FROM "forum"."forumObj" WHERE "theme_id" = :id';
                $em = $this->getDoctrine()->getManager();
                $stmt1 = $em->getConnection()->prepare($sql);
                $stmt1->execute(['id' => $slug]);
                $allR = $stmt1->fetchAll()[0]['count'];

                $length = ceil($allR/$limit);

                if ($length == 0) {
                    $length = 1;
                }
               
                return $this->render('beam/InForum.html', array('form' => $form->createView(), 'cForm' => $form78->createView(), 'ans' => $result, 'ttheme' => $result1, 'page' => $page, 'len' => $length, 'slug' => $slug));
            } else {
                return new Response('404');
            }
        }
        
    }
}

?>