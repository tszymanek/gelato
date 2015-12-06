<?php

namespace Szymanek\Bundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Szymanek\Bundle\Entity\Showcase;
use Szymanek\Bundle\Entity\Gelato;
use Szymanek\Bundle\Form\ShowcaseType;

/**
 * @Route("/showcase")
 */
class ShowcaseController extends Controller
{
    /**
     * @Route("/", name="showcase")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $showcase = $em->getRepository('TodaysGelatoBundle:Showcase')->find(1);

        return $this->render(
            'TodaysGelatoBundle:Showcase:index.html.twig', array(
                'showcase' => $showcase
            )
        );
    }

    /**
     * @Route("/new", name="showcase_new")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request)
    {
        $showcase = new Showcase();
        $em = $this->getDoctrine()->getManager();
        $cookies = $em->getRepository('TodaysGelatoBundle:Gelato')->findOneBy(array('name' => 'Cookies'));
        $showcase->getGelatos()->add($cookies);

        $form = $this->createForm(new ShowcaseType(), $showcase, array(
            'action' => $this->generateUrl('showcase_new'),
            'method' => 'POST',
        ));

        $form->handleRequest($request);

        if ($form->isSubmitted() &&  $form->isValid()) {
            $em->persist($showcase);
            $em->flush();

            return $this->redirectToRoute('showcase');
        }

        return $this->render(
            'TodaysGelatoBundle:Showcase:new.html.twig', array(
                'showcase' => $showcase,
                'form'   => $form->createView()
            )
        );
    }

    /**
     * @Route("/edit", name="showcase_edit")
     * @Method({"GET", "PUT"})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $showcase = $em->getRepository('TodaysGelatoBundle:Showcase')->findOneByName(array('name' => 'Sianożęty'));
        $gelatos = $em->getRepository('TodaysGelatoBundle:Gelato')->findAll();
//        $showcase->gelatos;
//        foreach($showcase->ge)
//        $showcase->getGelatos()->add(null)
//        for($i = 1; $i <= $showcase->getCapacity(); $i++)
//            if($showcase->getGelatos()->key($i))


        if (!$showcase) {
            throw $this->createNotFoundException('Unable to find Showcase entity.');
        }

        $form = $this->createForm(new ShowcaseType(), $showcase, array(
            'action' => $this->generateUrl('showcase_edit'),
            'method' => 'PUT',
        ));

//        $deleteForm = $this->createDeleteForm($id);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $cookies->setShowcase($showcase);
            $em->flush();

            return $this->redirectToRoute('showcase');
        }

        return $this->render(
            'TodaysGelatoBundle:Showcase:edit.html.twig', array(
//                'key'           => $showcase->getGelatos()->getCollection(),
                'showcase'      => $showcase,
                'gelatos'       => $gelatos,
                'form'   => $form->createView(),
//                'delete_form' => $deleteForm->createView(),
            )
        );
    }
}