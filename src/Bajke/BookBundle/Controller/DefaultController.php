<?php

namespace Bajke\BookBundle\Controller;

use Bajke\BookBundle\Entity\Book;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction(){
        $em = $this->getDoctrine()->getManager();
        $books = $em->getRepository('BookBundle:Book')->findAll();

        return array('books' => $books);
    }

    /**
     * @Route("/book/create")
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
