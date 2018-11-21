<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Analisis;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class AnalisisApiController extends Controller
{
    /**
     * Lists all analisi entities.
     *
     * @Route("/analisis/api/", name="analisis_api_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $analises = $em->getRepository('AppBundle:Analisis')->findAll();

        $response=new Response();
        $response->headers->add([
            'Content-Type'=>'application/json'
        ]);
        $response->setContent(json_encode($analises));
            
        return $response;
    }

    /**
     * Creates a new analisi entity.
     *
     * @Route("/analisis/api/new", name="analisis_api_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $analisi = new Analisis();
        $form = $this->createForm(
            'AppBundle\Form\AnalisisApiType',
            $analisi,
            [
                'csrf_protection' => false
            ]
        );
        $form->bind($request);
        $valid = $form->isValid();
        $response = new Response();
        if(false === $valid){
            $response->setStatusCode(400);
            $response->setContent(json_encode($this->getFormErrors($form)));
            return $response;
        }
        if (true === $valid) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($analisi);
            $em->flush();
            $response->setContent(json_encode($analisi));
        }
        return $response;
    }
    public function getFormErrors($form){
        $errors = [];
        if (0 === $form->count()){
            return $errors;
        }
        foreach ($form->all() as $child) {
            if (!$child->isValid()) {
                $errors[$child->getName()] = (string) $form[$child->getName()]->getErrors();
            }
        }
        return $errors;
    }

    /**
     * Creates a form to delete a analisi entity.
     *
     * @param Analisis $analisi The analisi entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Analisis $analisi)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('analisis_delete', array('id' => $analisi->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}