<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Analisis;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Analisi controller.
 *
 * @Route("analisis")
 */
class AnalisisController extends Controller
{
    /**
     * Lists all analisi entities.
     *
     * @Route("/", name="analisis_index")
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
     * @Route("/new", name="analisis_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $analisi = new Analisis();
        $form = $this->createForm('AppBundle\Form\AnalisisType', $analisi);
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
     * Finds and displays a analisi entity.
     *
     * @Route("/{id}", name="analisis_show")
     * @Method("GET")
     */
    public function showAction(Analisis $analisi)
    {
        $deleteForm = $this->createDeleteForm($analisi);

        return $this->render('analisis/show.html.twig', array(
            'analisi' => $analisi,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing analisi entity.
     *
     * @Route("/{id}/edit", name="analisis_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Analisis $analisi)
    {
        $deleteForm = $this->createDeleteForm($analisi);
        $editForm = $this->createForm('AppBundle\Form\AnalisisType', $analisi);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('analisis_edit', array('id' => $analisi->getId()));
        }

        return $this->render('analisis/edit.html.twig', array(
            'analisi' => $analisi,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a analisi entity.
     *
     * @Route("/{id}", name="analisis_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Analisis $analisi)
    {
        $form = $this->createDeleteForm($analisi);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($analisi);
            $em->flush();
        }

        return $this->redirectToRoute('analisis_index');
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
