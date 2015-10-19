<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 10/18/2015
 * Time: 5:05 PM
 */

namespace Bajke\BookBundle\Controller;


use JMS\Serializer\SerializationContext;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class BaseController extends Controller {

    protected function serialize($data, $format = 'json'){
        $context = new SerializationContext();
        $context->setSerializeNull(true);

        return $this->container->get('jms_serializer')
            ->serialize($data, $format, $context);
    }

    protected function createApiResponse($data, $code = 200){
        $json = $this->serialize($data);

        return new Response($json, $code, array(
            'Content-Type' => 'application/json'
        ));
    }

}