<?php

namespace Szymanek\Bundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Szymanek\Bundle\Entity\Gelato;
use Szymanek\Bundle\Form\GelatoType;

/**
 * @Route("/gelato")
 */
class GelatoController extends Controller
{

    /**
     * @Route("/", name="gelato")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $gelatos = $em->getRepository('TodaysGelatoBundle:Gelato')->findAll();

        return $this->render(
            'TodaysGelatoBundle:Gelato:index.html.twig',
            array('gelatos' => $gelatos)
        );
    }

    /**
     * @Route("/new", name="gelato_new")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request)
    {
        $gelato = new Gelato();
        $form = $this->createForm(new GelatoType(), $gelato, array(
            'action' => $this->generateUrl('gelato_new'),
            'method' => 'POST',
        ));

        $form->handleRequest($request);

        if ($form->isSubmitted() &&  $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($gelato);
            $em->flush();

            return $this->redirect($this->generateUrl('gelato_show', array('id' => $gelato->getId())));
        }

        return $this->render(
            'TodaysGelatoBundle:Gelato:new.html.twig', array(
                'gelato' => $gelato,
                'form'   => $form->createView()
            )
        );
    }

    /**
     * @Route("/{id}", name="gelato_show")
     * @Method("GET")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $gelato = $em->getRepository('TodaysGelatoBundle:Gelato')->find($id);

        if (!$gelato) {
            throw $this->createNotFoundException('Unable to find Gelato entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render(
            'TodaysGelatoBundle:Gelato:show.html.twig', array(
                'gelato'      => $gelato,
                'delete_form' => $deleteForm->createView()
            )
        );
    }

    /**
     * @Route("/{id}/edit", name="gelato_edit")
     * @Method({"GET", "PUT"})
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $gelato = $em->getRepository('TodaysGelatoBundle:Gelato')->find($id);

        if (!$gelato) {
            throw $this->createNotFoundException('Unable to find Gelato entity.');
        }

        $form = $this->createForm(new GelatoType(), $gelato, array(
            'action' => $this->generateUrl('gelato_edit', array('id' => $gelato->getId())),
            'method' => 'PUT',
        ));

        $deleteForm = $this->createDeleteForm($id);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('gelato_show', array('id' => $id)));
        }

        return $this->render(
            'TodaysGelatoBundle:Gelato:edit.html.twig', array(
                'gelato'      => $gelato,
                'form'   => $form->createView(),
                'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
     * @Route("/{id}", name="gelato_delete")
     * @Method("DELETE")
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isSubmitted() &&  $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $gelato = $em->getRepository('TodaysGelatoBundle:Gelato')->find($id);

            if (!$gelato) {
                throw $this->createNotFoundException('Unable to find Gelato entity.');
            }

            $em->remove($gelato);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('gelato'));
    }

    /**
     * @param $id
     * @return \Symfony\Component\Form\Form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('gelato_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
