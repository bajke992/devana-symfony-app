<?php

namespace Bajke\BookBundle\Controller;

use Bajke\BookBundle\Entity\Book;
use Bajke\BookBundle\Form\BookType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="index")
     * @Template()
     */
    public function indexAction(){
        $user = $this->checkUser();

        return array('user' => $user);
    }

//    /**
//     * @Route("/welcome", name="welcome")
//     * @Template()
//     */
//    public function welcomeAction(){
//        if($this->getUser()){
//            return new RedirectResponse($this->generateUrl('profile'));
//        } else {
//            return new RedirectResponse($this->generateUrl('index'));
//        }
//    }

    /**
     * @Route("/profile", name="profile")
     * @Template()
     */
    public function profileAction(){
        $user = $this->checkUser();
        if(!$user){ return new RedirectResponse($this->generateUrl('index')); }

        return array('user' => $user);
    }

    /**
     * @Route("/book", name="book_list")
     * @Template()
     */
    public function listAction(){
        $user = $this->checkUser();
        if(!$user){ return new RedirectResponse($this->generateUrl('index')); }

//        $books = $em->getRepository('BookBundle:Book')->findAll();
        $books = $user->getBooks();

        return array('books' => $books, 'user' => $user);
    }

    /**
     * @Route("/book/create", name="book_create")
     * @Template("BookBundle:Default:_form.html.twig")
     */
    public function createAction(){
        $user = $this->checkUser();
        if(!$user){ return new RedirectResponse($this->generateUrl('index')); }

        $em = $this->getDoctrine()->getManager();
        $book = new Book();
        $book->getOwner($user->getId());

        $form = $this->createForm(new BookType(), $book, array('is_owner_disabled' => true));

        if($form->isValid()){
            $em->persist($book);
            $em->flush();

            return new RedirectResponse($this->generateUrl('book_list'));
        }

        return array('create' => true, 'book' => $book, 'user' => $user, 'form' => $form->createView());
    }

    /**
     * @Route("/book/update")
     * @Template("BookBundle:Default:_form.html.twig")
     */
    public function updateAction(Request $request){
        $user = $this->checkUser();
        if(!$user){ return new RedirectResponse($this->generateUrl('index')); }

        $em = $this->getDoctrine()->getManager();
        $id = $request->get("id");
        $book = $em->getRepository('BookBundle:Book')->find($id);

        if(!$book){
            throw $this->createNotFoundException('No Book fount for id: ' . $id);
        }

        $form = $this->createForm(new BookType(), $book, array('is_edit' => true, 'is_owner_disabled' => true));

        if($form->isValid()){
            $em->flush();

            return new RedirectResponse($this->generateUrl('book_list'));
        }

        return array('create' => false, 'book' => $book, 'user' => $user, 'form' => $form->createView());
    }

    /**
     * @Route("/book/delete")
     *
     */
    public function deleteAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $id = $request->get("id");
        $book = $em->getRepository('BookBundle:Book')->find($id);

        if(!$book){
            throw $this->createNotFoundException('No Book fount for id: ' . $id);
        }

        $em->remove($book);
        $em->flush();

        return new RedirectResponse($this->generateUrl('book_list'));
    }

    /**
     * @Route("/auth")
     */
    public function loginAction(){
        return $this->render('BookBundle:Default:login.html.twig');
    }

	/**
	 * @Route("/file")
	 */
	public function fileAction(){
		$file = $this->get('kernel')->getRootDir()."/logs/security.log";
		return new Response(file_get_contents($file), 200);
	}






    /**
     * @Route("/hello/{name}")
     * @Template()
     */
    public function helloAction($name)
    {
        return array('name' => $name);
    }

    protected function checkUser(){
        $repo = $this->getDoctrine()->getRepository('BookBundle:User');

        if($this->getUser()) {
            $tmp = $this->getUser();
            $user = $repo->findOneBy(array('id' => $tmp->getId()));
        } else {
            $user = null;
        }

        return $user;
    }
}
