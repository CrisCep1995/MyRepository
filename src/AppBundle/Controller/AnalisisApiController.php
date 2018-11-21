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

        return $this->render('analisis/index.html.twig', array(
            'analises' => $analises,
        ));
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
        $form = $this->createForm('AppBundle\Form\AnalisisApiType', $analisi);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($analisi);
            $em->flush();

            return $this->redirectToRoute('analisis_show', array('id' => $analisi->getId()));
        }

        return $this->render('analisis/new.html.twig', array(
            'analisi' => $analisi,
            'form' => $form->createView(),
        ));
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