<?php

namespace Szymanek\Bundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Szymanek\Bundle\Entity\Image;
use Szymanek\Bundle\Entity\MultipleImages;
use Szymanek\Bundle\Form\ImageType;
use Szymanek\Bundle\Form\MultipleImagesType;

/**
 * @Route("/gelatoimage")
 */
class GelatoImageController extends Controller
{
    /**
     * @Route("/", name="gelatoimage")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $gelatoImages = $em->getRepository('TodaysGelatoBundle:Image')->findAll();

        return $this->render(
            'TodaysGelatoBundle:GelatoImage:index.html.twig', array(
                'gelatoImages' => $gelatoImages
            )
        );
    }

    /**
     * @Route("/new", name="gelatoimage_new")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request)
    {
        $images = new MultipleImages();
        $form = $this->createForm(new MultipleImagesType(), $images, array(
            'action' => $this->generateUrl('gelatoimage_new'),
            'method' => 'POST',
        ));

        $form->handleRequest($request);

        if ($form->isSubmitted() &&  $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            foreach($images->getFiles() as $file){
                $newFile = new Image();
                $newFile->setFile($file);
                $em->persist($newFile);
            }

            $em->flush();

            return $this->redirectToRoute('gelatoimage');
        }

        return $this->render(
            'TodaysGelatoBundle:GelatoImage:new.html.twig', array(
                'images' => $images,
                'form'   => $form->createView()
            )
        );
    }

    /**
     * @Route("/{id}", name="gelatoimage_show")
     * @Method("GET")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $gelatoImage = $em->getRepository('TodaysGelatoBundle:Image')->find($id);

        if (!$gelatoImage) {
            throw $this->createNotFoundException('Unable to find Gelato Image entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render(
            'TodaysGelatoBundle:GelatoImage:show.html.twig', array(
                'gelatoImage'      => $gelatoImage,
                'delete_form' => $deleteForm->createView()
            )
        );
    }

    /**
     * @Route("/{id}/edit", name="gelatoimage_edit")
     * @Method({"GET", "PUT"})
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $gelatoImage = $em->getRepository('TodaysGelatoBundle:Image')->find($id);

        if (!$gelatoImage) {
            throw $this->createNotFoundException('Unable to find Gelato Image entity.');
        }

        $form = $this->createForm(new ImageType(), $gelatoImage, array(
            'action' => $this->generateUrl('gelatoimage_edit', array('id' => $gelatoImage->getId())),
            'method' => 'PUT',
        ));

        $deleteForm = $this->createDeleteForm($id);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('gelatoimage_show', array('id' => $id)));
        }

        return $this->render(
            'TodaysGelatoBundle:GelatoImage:edit.html.twig', array(
                'gelatoImage'      => $gelatoImage,
                'form'   => $form->createView(),
                'delete_form' => $deleteForm->createView(),
            )
        );
    }

    /**
     * @Route("/{id}", name="gelatoimage_delete")
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
            $gelato = $em->getRepository('TodaysGelatoBundle:Image')->find($id);

            if (!$gelato) {
                throw $this->createNotFoundException('Unable to find Gelato Image entity.');
            }

            $em->remove($gelato);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('gelatoimage'));
    }

    /**
     * @param $id
     * @return \Symfony\Component\Form\Form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('gelatoimage_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
            ;
    }
}