<?php

namespace Bajke\BookBundle\Controller;


use Bajke\BookBundle\Entity\Book;
use Bajke\BookBundle\Form\BookType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class ApiController extends BaseController {

    /**
     * @Route("/api/book")
     * @Method("POST")
     */
    public function createAction(Request $request){
//        $body = $request->getContent();
//        $arr = json_decode($body, true);
        $book = new Book();
        $form = $this->createForm(new BookType(), $book);
        $this->processForm($request, $form);
//        $form->submit($arr);
        $em = $this->getDoctrine()->getManager();
        $em->persist($book);
        $em->flush();

//        $data = $this->serialize($book);

//        $response = new Response(json_encode($data), 201);
        $bookUrl = $this->generateUrl(
            'api_book_get',
            ['id' => $book->getId()]
        );

//        $response->headers->set('Location', $bookUrl);
//        $response->headers->set('Content-type', 'application/json');

//        $response = new Response($data, 201);
        $response = $this->createApiResponse($book, 201);
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

//        $data = $this->serialize($book);

//        $response = new Response(json_encode($data), 200);
//        $response->headers->set('Content-type', 'application/json');
//        $response = new Response($data, 200);
        $response = $this->createApiResponse($book, 200);
        return $response;
    }

    /**
     * @Route("/api/book")
     * @Method("GET")
     */
    public function listAction(){
        $books = $this->getDoctrine()->getRepository('BookBundle:Book')->findAll();
//        $data = array('books' => array());

//        foreach($books as $book){
//            $data['books'][] = $this->serializeBook($book);
//        }
//        $data = $this->serialize(['books' => $books]);

//        $response = new Response(json_encode($data), 200);
//        $response->headers->set('Content-Type', 'application/json');

//        $response = new Response($data, 200);
        $response = $this->createApiResponse(['books' => $books], 200);

        return $response;
    }

    /**
     * @Route("/api/book/{id}", name="api_book_update")
     * @Method({"PUT", "PATCH"})
     */
    public function updateAction($id, Request $request){
        $repo = $this->getDoctrine()->getRepository('BookBundle:Book');
        $book = $repo->findOneBy(array('id' => $id));

        if(!$book){
            throw $this->createNotFoundException(
                'No book found with id: '.$id
            );
        }

        $form = $this->createForm(new BookType(), $book, array('is_edit' => true, 'is_owner_disabled' => true));
        $this->processForm($request, $form);

        $em = $this->getDoctrine()->getManager();
        $em->persist($book);
        $em->flush();

        $bookUrl = $this->generateUrl(
            'api_book_get',
            ['id' => $book->getId()]
        );

//        $data = $this->serialize($book);
//        $response = new Response($data, 200);
        $response = $this->createApiResponse($book, 200);
        $response->headers->set('Location', $bookUrl);
        return $response;
    }

    /**
     * @Route("/api/book/{id}", name="api_book_delete")
     * @Method("DELETE")
     */
    public function deleteAction($id){
        $repo = $this->getDoctrine()->getRepository('BookBundle:Book');
        $book = $repo->findOneBy(array('id' => $id));

        if($book){
            $em = $this->getDoctrine()->getManager();
            $em->remove($book);
            $em->flush();
        }

        return new Response(null, 204);
    }


    private function processForm(Request $request, FormInterface $form){
        $data = json_decode($request->getContent(), true);
        $clearMissing = $request->getMethod() != 'PATCH';
        $form->submit($data, $clearMissing);
    }

//    private function serializeBook($data){
//        $em = $this->getDoctrine()->getRepository('BookBundle:User');
//        $usr = $em->findOneBy(array('id' => $book->getOwner()));
//        return array(
//            'id' => $book->getId(),
//            'title' => $book->getTitle(),
//            'description' => $book->getDescription(),
//            'owner' => array(
//                'id' => $usr->getId(),
//                'nickname' => $usr->getNickname(),
//                'email' => $usr->getEmail(),
//                'username' => $usr->getUsername(),
//                'google_id' => $usr->getGoogleId(),
//                'real_name' => $usr->getRealname(),
//                'roles' => $usr->getRoles(),
//            ),
//        );
//
//        return $this->container->get('jms_serializer')
//            ->serialize($data, 'json');
//    }

}