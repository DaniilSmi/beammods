<?php
	
namespace App\Controller;

use App\Entity\AdminlogForm;
use App\Form\AdminlogFormController;

use App\Entity\SearchAdminForm;
use App\Form\SearchAdminFormController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\CommentForm;
use App\Form\CommentFormController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;


class AdminController extends AbstractController 
{

     /**
     * Matches /admin/*
     *
     * @Route("/admin/{slug}/{slave}", name="admin_show")
     */

    public function show($slug = null, $slave = null,  Request $request)
    {		
        $session = new Session();
        $session->start();
        $sessionResult = $session->get('admin');

        $task1 = new AdminlogForm();
        $form1 = $this->createForm(AdminlogFormController::class, $task1);

        $form1->handleRequest($request);
        $searchTask = new SearchAdminForm();
        $searchForm = $this->createForm(SearchAdminFormController::class, $searchTask);


                if ($form1->isSubmitted() && $form1->isValid()) {
                    // get the data from request
                    $userData = $request->request->all()['adminlog_form_controller'];
                    // set the class value
                    $task1->setLogin($userData['login']);
                    $task1->setPassword($userData['password']);

                    // search in admins

                    $sql = 'SELECT * FROM "User"."admin" WHERE "login" = :login';
                    $em = $this->getDoctrine()->getManager();
                    $stmt1 = $em->getConnection()->prepare($sql);
                    $stmt1->execute(['login' => $task1->getLogin()]);
                    $result = $stmt1->fetchAll()[0];

                    if ($task1->getPassword() == $result['password']) {
                        $session->set('admin', $result);
                        return $this->redirectToRoute('admin');
                    } else {
                        echo "<script>alert('Неверный логин или пароль!');</script>";
                    }

                }

        if (!empty($sessionResult)) {
            if (!isset($slug)) {
               
                 
        

                

                if (empty($sessionResult)) {
                    return $this->render('beam/adminlog.html', array('form1' => $form1->createView()));
                } else {
                    return $this->render('beam/admin.html', array());
                }
            } else {
                if ($slug == 'logout') {
                    $session->remove('admin');
                    return $this->redirectToRoute('admin');
                } else if ($slug == 'users') {
                    if ($slave == 'admins') {
                        // usersjustAdminsAdmin.html
                        $sql = 'SELECT * FROM "User"."admin" ORDER BY "id" LIMIT 40';
                        $em = $this->getDoctrine()->getManager();
                        $stmt1 = $em->getConnection()->prepare($sql);
                        $stmt1->execute();
                        $result = $stmt1->fetchAll();

                        $searchForm->handleRequest($request);

                        if ($searchForm->isSubmitted() && $searchForm->isValid()) {
                            $userData = $request->request->all()['search_admin_form_controller'];
                            $searchTask->setValue($userData['value']);

                            $sql = 'SELECT * FROM "User"."admin" WHERE "login" % :login';
                            $em = $this->getDoctrine()->getManager();
                            $stmt1 = $em->getConnection()->prepare($sql);
                            $stmt1->execute(['login' => $searchTask->getValue()]);
                            $result = $stmt1->fetchAll();
                            
                        }

                        if (isset($_POST['submitNewAdmin'])) {
                            $sql = 'INSERT INTO "User"."admin" ("login", "password") VALUES (:login, :password)';
                            $em = $this->getDoctrine()->getManager();
                            $stmt1 = $em->getConnection()->prepare($sql);
                            $stmt1->execute(['login' => $_POST['newAdminLogin'], 'password' => $_POST['newAdminPassword']]);
                            $result = $stmt1->fetchAll();

                            return $this->redirectToRoute('admin');
                        }

                        if (isset($_POST['adminUserSubmit'])) {
                            if (isset($_POST['chBox'])) {
                                $sql = 'DELETE FROM "User"."admin" WHERE "id" = :id';
                                $em = $this->getDoctrine()->getManager();
                                $stmt1 = $em->getConnection()->prepare($sql);
                                $stmt1->execute(['id' => $_POST['userId']]);

                                return $this->redirectToRoute('admin');
                            }
                        }
                        

                         return $this->render('beam/usersjustAdminsAdmin.html', array('users' => $result, 'searchForm' => $searchForm->createView()));
                    } else if ($slave == 'users') {
                        $sql = 'SELECT * FROM "User"."user" ORDER BY "id" LIMIT 40';
                        $em = $this->getDoctrine()->getManager();
                        $stmt1 = $em->getConnection()->prepare($sql);
                        $stmt1->execute();
                        $result = $stmt1->fetchAll();
                        $searchForm->handleRequest($request);

                        if ($searchForm->isSubmitted() && $searchForm->isValid()) {
                            $userData = $request->request->all()['search_admin_form_controller'];
                            $searchTask->setValue($userData['value']);

                            $sql = 'SELECT * FROM "User"."user" WHERE "login" % :login';
                            $em = $this->getDoctrine()->getManager();
                            $stmt1 = $em->getConnection()->prepare($sql);
                            $stmt1->execute(['login' => $searchTask->getValue()]);
                            $result = $stmt1->fetchAll();
                            
                        }

                        if (isset($_POST['adminUserSubmit'])) {
                            if (isset($_POST['chBox'])) {
                                $sql1 = 'SELECT * FROM "User"."user" WHERE "id" = :id';
                                $em1 = $this->getDoctrine()->getManager();
                                $stmt11 = $em1->getConnection()->prepare($sql1);
                                $stmt11->execute(['id' => $_POST['userId']]);
                                $result1 = $stmt11->fetchAll()[0];

                                $sql = 'DELETE FROM "User"."user" WHERE "id" = :id';
                                $em = $this->getDoctrine()->getManager();
                                $stmt1 = $em->getConnection()->prepare($sql);
                                $stmt1->execute(['id' => $_POST['userId']]);

                                

                                if ($result1['imageName'] != 'defaultUserImg.png') {
                                    unlink($this->getParameter('img').$result1['imageName']);
                                }

                                return $this->redirectToRoute('admin');
                            }
                           // print_r($_POST);
                        } 
                        

                        return $this->render('beam/usersjustAdmin.html', array('searchForm' => $searchForm->createView(), 'users' => $result));
                    } else {
                        return $this->render('beam/usersAdmin.html', array());
                    }
                } else if ($slug == 'pages') {
                    if ($slave == 'aboutus') {
                        $sql1 = 'SELECT * FROM "SomePages"."aboutUs" WHERE id = 1';
                        $em1 = $this->getDoctrine()->getManager();
                        $stmt11 = $em1->getConnection()->prepare($sql1);
                        $stmt11->execute();
                        $result1 = $stmt11->fetchAll()[0];

                        if (isset($_POST['submitAboutUs'])) {
                            $sql1 = 'UPDATE "SomePages"."aboutUs" SET "text" = :text1 WHERE "id" = 1';
                            $em1 = $this->getDoctrine()->getManager();
                            $stmt11 = $em1->getConnection()->prepare($sql1);
                            $stmt11->execute(['text1' => $_POST['textAbout']]);

                            return $this->redirectToRoute('aboutUs');
                        }

                        return $this->render('beam/aboutusadmin.html', array('info' => $result1));
                    } else if ($slave == 'contacts') {
                        $sql1 = 'SELECT * FROM "SomePages"."contacts" WHERE id = 1';
                        $em1 = $this->getDoctrine()->getManager();
                        $stmt11 = $em1->getConnection()->prepare($sql1);
                        $stmt11->execute();
                        $result1 = $stmt11->fetchAll()[0];

                        if (isset($_POST['submitAboutUs'])) {
                            $sql1 = 'UPDATE "SomePages"."contacts" SET "text" = :text1 WHERE "id" = 1';
                            $em1 = $this->getDoctrine()->getManager();
                            $stmt11 = $em1->getConnection()->prepare($sql1);
                            $stmt11->execute(['text1' => $_POST['textAbout']]);

                            return $this->redirectToRoute('contacts');
                        }

                        return $this->render('beam/aboutusadmin.html', array('info' => $result1));
                    } else if ($slave == 'creator') {
                        $sql1 = 'SELECT * FROM "SomePages"."creator" WHERE id = 1';
                        $em1 = $this->getDoctrine()->getManager();
                        $stmt11 = $em1->getConnection()->prepare($sql1);
                        $stmt11->execute();
                        $result1 = $stmt11->fetchAll()[0];

                        if (isset($_POST['submitAboutUs'])) {
                            $sql1 = 'UPDATE "SomePages"."creator" SET "text" = :text1 WHERE "id" = 1';
                            $em1 = $this->getDoctrine()->getManager();
                            $stmt11 = $em1->getConnection()->prepare($sql1);
                            $stmt11->execute(['text1' => $_POST['textAbout']]);

                            return $this->redirectToRoute('creator');
                        }

                        return $this->render('beam/aboutusadmin.html', array('info' => $result1));
                    } else if ($slave == 'howload') {
                        $sql1 = 'SELECT * FROM "SomePages"."howload" WHERE id = 1';
                        $em1 = $this->getDoctrine()->getManager();
                        $stmt11 = $em1->getConnection()->prepare($sql1);
                        $stmt11->execute();
                        $result1 = $stmt11->fetchAll()[0];

                        if (isset($_POST['submitAboutUs'])) {
                            $sql1 = 'UPDATE "SomePages"."howload" SET "text" = :text1 WHERE "id" = 1';
                            $em1 = $this->getDoctrine()->getManager();
                            $stmt11 = $em1->getConnection()->prepare($sql1);
                            $stmt11->execute(['text1' => $_POST['textAbout']]);

                            return $this->redirectToRoute('howToLoad');
                        }

                        return $this->render('beam/aboutusadmin.html', array('info' => $result1));
                    } else if ($slave == 'setup') {
                        $sql1 = 'SELECT * FROM "SomePages"."setup" WHERE id = 1';
                        $em1 = $this->getDoctrine()->getManager();
                        $stmt11 = $em1->getConnection()->prepare($sql1);
                        $stmt11->execute();
                        $result1 = $stmt11->fetchAll()[0];

                        if (isset($_POST['submitAboutUs'])) {
                            $sql1 = 'UPDATE "SomePages"."setup" SET "text" = :text1 WHERE "id" = 1';
                            $em1 = $this->getDoctrine()->getManager();
                            $stmt11 = $em1->getConnection()->prepare($sql1);
                            $stmt11->execute(['text1' => $_POST['textAbout']]);

                            return $this->redirectToRoute('setup');
                        }

                        return $this->render('beam/aboutusadmin.html', array('info' => $result1));
                    } else if ($slave=='indexpage') {
                        $sql1 = 'SELECT * FROM "SomePages"."indexPage" WHERE "id" = 1';
                        $em1 = $this->getDoctrine()->getManager();
                        $stmt11 = $em1->getConnection()->prepare($sql1);
                        $stmt11->execute();
                        $result1 = $stmt11->fetchAll()[0];

                        if (isset($_POST['bIndexAdmin'])) {
                            $sql1 = 'UPDATE "SomePages"."indexPage" SET "text" = :text1 WHERE "id" = 1';
                            $em1 = $this->getDoctrine()->getManager();
                            $stmt11 = $em1->getConnection()->prepare($sql1);
                            $stmt11->execute(['text1' => $_POST['indexAdminPage']]);

                            if (isset($_FILES['imageIndexAdmin'])) {
                                if (file_exists($this->getParameter('imgIndex').$result1['image'])) {
                                    unlink($this->getParameter('imgIndex').$result1['image']);
                                }
                                 
                                // upload file
                                
                                // allowed file types
                                $allowed = array('gif', 'png', 'jpg', 'jpeg', 'svg');
                                $ext = pathinfo($_FILES['imageIndexAdmin']['name'], PATHINFO_EXTENSION);
                                if (in_array($ext, $allowed)) {
                                    move_uploaded_file($_FILES['imageIndexAdmin']['tmp_name'], $this->getParameter('imgIndex').$_FILES['imageIndexAdmin']['name']);
                                    $sql1 = 'UPDATE "SomePages"."indexPage" SET "image" = :text1 WHERE "id" = 1';
                                    $em1 = $this->getDoctrine()->getManager();
                                    $stmt11 = $em1->getConnection()->prepare($sql1);
                                    $stmt11->execute(['text1' => $_FILES['imageIndexAdmin']['name']]);
                                }
                            }

                            return $this->redirectToRoute('index');
                        }

                        return $this->render('beam/adminIndexPage.html', array('info' => $result1));
                    }

                    if (!isset($slave)) {
                     return $this->render('beam/adminPages.html', array());
                    }
                }
                return new Response('');
            }

        } else {
            return $this->render('beam/adminlog.html', array('form1' => $form1->createView()));
        }
    }
}

?>