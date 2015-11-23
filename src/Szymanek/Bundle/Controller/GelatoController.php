<?php

namespace Szymanek\Bundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
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
     */
    public function newAction(Request $request)
    {
        $gelato = new Gelato();
        $form = $this->createForm(new GelatoType(), $gelato, array(
            'action' => $this->generateUrl('gelato_new'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        $form->handleRequest($request);

        if ($form->isSubmitted() &&  $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($gelato);
            $em->flush();

            return $this->redirect($this->generateUrl('gelato_show', array('id' => $gelato->getId())));
        }

        return $this->render(
            'TodaysGelatoBundle:Gelato:new.html.twig', array(
                'entity' => $gelato,
                'form'   => $form->createView()
            )
        );
    }

    /**
     * @Route("/{id}", name="gelato_show")
     * @Method("GET")
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
     * Displays a form to edit an existing Gelato entity.
     *
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

        $editForm = $this->createForm(new GelatoType(), $gelato, array(
            'action' => $this->generateUrl('gelato_edit', array('id' => $gelato->getId())),
            'method' => 'PUT',
        ));

        $editForm->add('submit', 'submit', array('label' => 'Update'));

        $deleteForm = $this->createDeleteForm($id);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('gelato_show', array('id' => $id)));
        }

        return $this->render(
            'TodaysGelatoBundle:Gelato:edit.html.twig', array(
                'entity'      => $gelato,
                'edit_form'   => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            )
        );
    }

//    /**
//    * Creates a form to edit a Gelato entity.
//    *
//    * @param Gelato $entity The entity
//    *
//    * @return \Symfony\Component\Form\Form The form
//    */
//    private function createEditForm(Gelato $entity)
//    {
//        $form = $this->createForm(new GelatoType(), $entity, array(
//            'action' => $this->generateUrl('gelato_update', array('id' => $entity->getId())),
//            'method' => 'PUT',
//        ));
//
//        $form->add('submit', 'submit', array('label' => 'Update'));
//
//        return $form;
//    }
//    /**
//     * Edits an existing Gelato entity.
//     *
//     * @Route("/{id}", name="gelato_update")
//     * @Method("PUT")
//     * @Template("TodaysGelatoBundle:Gelato:edit.html.twig")
//     */
//    public function updateAction(Request $request, $id)
//    {
//        $em = $this->getDoctrine()->getManager();
//
//        $entity = $em->getRepository('TodaysGelatoBundle:Gelato')->find($id);
//
//        if (!$entity) {
//            throw $this->createNotFoundException('Unable to find Gelato entity.');
//        }
//
//        $deleteForm = $this->createDeleteForm($id);
//        $editForm = $this->createEditForm($entity);
//        $editForm->handleRequest($request);
//
//        if ($editForm->isValid()) {
//            $em->flush();
//
//            return $this->redirect($this->generateUrl('gelato_edit', array('id' => $id)));
//        }
//
//        return array(
//            'entity'      => $entity,
//            'edit_form'   => $editForm->createView(),
//            'delete_form' => $deleteForm->createView(),
//        );
//    }
    /**
     * Deletes a Gelato entity.
     *
     * @Route("/{id}", name="gelato_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('TodaysGelatoBundle:Gelato')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Gelato entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('gelato'));
    }

    /**
     * Creates a form to delete a Gelato entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
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
