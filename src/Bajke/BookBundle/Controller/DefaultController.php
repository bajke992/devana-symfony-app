<?php

namespace Bajke\BookBundle\Controller;

use Bajke\BookBundle\Entity\Book;
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
        $repo = $this->getDoctrine()->getRepository('BookBundle:User');

        if($this->getUser()) {
            $tmp = $this->getUser();
            $user = $repo->findOneBy(array('id' => $tmp->getId()));
        }

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
        $repo = $this->getDoctrine()->getRepository('BookBundle:User');

        if($this->getUser()) {
            $tmp = $this->getUser();
            $user = $repo->findOneBy(array('id' => $tmp->getId()));
        } else {
            return new RedirectResponse($this->generateUrl('index'));
        }

        return array('user' => $user);
    }

    /**
     * @Route("/book", name="book_list")
     * @Template()
     */
    public function listAction(){
        $em = $this->getDoctrine()->getManager();
        $books = $em->getRepository('BookBundle:Book')->findAll();

        return array('books' => $books, 'user' => $this->getUser());
    }

    /**
     * @Route("/book/create", name="book_create")
     * @Template("BookBundle:Default:_form.html.twig")
     */
    public function createAction(){
        $em = $this->getDoctrine()->getManager();
        $book = new Book();

        return array('create' => true, 'book' => $book);
    }

    /**
     * @Route("/book/update")
     * @Template("BookBundle:Default:_form.html.twig")
     */
    public function updateAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $id = $request->get("id");
        $book = $em->getRepository('BookBundle:Book')->find($id);

        if(!$book){
            throw $this->createNotFoundException('No Book fount for id: ' . $id);
        }

        return array('create' => false, 'book' => $book);
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

        return $this->redirect('/');
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
}
