<?php

namespace Bajke\BookBundle\Controller;


use Bajke\BookBundle\Entity\Book;
use Bajke\BookBundle\Form\BookType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class ApiController extends Controller {

    /**
     * @Route("/api/book")
     * @Method("POST")
     */
    public function createAction(Request $request){
        $body = $request->getContent();
        $arr = json_decode($body, true);
        $book = new Book();
        $form = $this->createForm(new BookType(), $book);
        $form->submit($arr);
        $em = $this->getDoctrine()->getManager();
        $em->persist($book);
        $em->flush();

        $data = $this->serializeBook($book);

//        $response = new Response(json_encode($data), 201);
        $bookUrl = $this->generateUrl(
            'api_book_get',
            ['id' => $book->getId()]
        );

//        $response->headers->set('Location', $bookUrl);
//        $response->headers->set('Content-type', 'application/json');

        $response = new JsonResponse($data, 201);
        $response->headers->set('Location', $bookUrl);

        return $response;
    }

    /**
     * @Route("/api/book/{id}", name="api_book_get")
     * @Method("GET")
     */
    public function getAction($id){
        $em = $this->getDoctrine()->getManager();
        $book = $em->getRepository('BookBundle:Book')->findOneBy(array('id' => $id));

        if(!$book){
            throw $this->createNotFoundException(
                'No book found with id: '.$id
            );
        }

        $data = $this->serializeBook($book);

//        $response = new Response(json_encode($data), 200);
//        $response->headers->set('Content-type', 'application/json');
        $response = new JsonResponse($data, 200);
        return $response;
    }

    /**
     * @Route("/api/book")
     * @Method("GET")
     */
    public function listAction(){
        $books = $this->getDoctrine()->getRepository('BookBundle:Book')->findAll();
        $data = array('books' => array());

        foreach($books as $book){
            $data['books'][] = $this->serializeBook($book);
        }

//        $response = new Response(json_encode($data), 200);
//        $response->headers->set('Content-Type', 'application/json');

        $response = new JsonResponse($data, 200);

        return $response;
    }


    private function serializeBook(Book $book){
        return array(
            'id' => $book->getId(),
            'title' => $book->getTitle(),
            'description' => $book->getDescription(),
        );
    }

}