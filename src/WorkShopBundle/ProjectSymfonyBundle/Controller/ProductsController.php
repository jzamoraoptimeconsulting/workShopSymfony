<?php

namespace WorkShopBundle\ProjectSymfonyBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use WorkShopBundle\ProjectSymfonyBundle\Entity\Products;
use Symfony\Component\Form\FormError;

/**
 * Products controller.
 *
 * @Route("/products")
 */
class ProductsController extends Controller
{
    /**
     * Lists all Products entities.
     *
     * @Route("/", name="products_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $products = $em->getRepository('ProjectSymfonyBundle:Products')->findAll();

        return $this->render('ProjectSymfonyBundle::products/index.html.twig', array(
            'products' => $products,
        ));
    }

    /**
     * Creates a new Products entity.
     *
     * @Route("/new", name="products_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $product = new Products();
        $form = $this->createForm('WorkShopBundle\ProjectSymfonyBundle\Form\ProductsType', $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($product);

            try{
                $em->flush();
            }catch(\Exception $e){
                if(stripos($e->getMessage(),'duplicate entry')!==false){
                    $form->get('code')->addError(new FormError('El nombre y el codigo no pueden repetirse con otros productos '));
                }

                return $this->render('ProjectSymfonyBundle::products/new.html.twig', array(
                    'product' => $product,
                    'form' => $form->createView(),
                ));
            }

            return $this->redirectToRoute('products_index');
        }

        return $this->render('ProjectSymfonyBundle::products/new.html.twig', array(
            'product' => $product,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Products entity.
     *
     * @Route("/{id}", name="products_show")
     * @Method("GET")
     */
    public function showAction(Products $product)
    {
        $deleteForm = $this->createDeleteForm($product);

        return $this->render('ProjectSymfonyBundle::products/show.html.twig', array(
            'product' => $product,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Products entity.
     *
     * @Route("/{id}/edit", name="products_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Products $product)
    {
        $deleteForm = $this->createDeleteForm($product);
        $editForm = $this->createForm('WorkShopBundle\ProjectSymfonyBundle\Form\ProductsType', $product);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();

            return $this->redirectToRoute('products_index');
        }

        return $this->render('ProjectSymfonyBundle::products/edit.html.twig', array(
            'product' => $product,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Products entity.
     *
     * @Route("/{id}", name="products_delete")
     */
    public function deleteAction(Request $request, Products $product)
    {
        $form = $this->createDeleteForm($product);
        $form->handleRequest($request);

        //if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($product);
            $em->flush();
        //}

        return $this->redirectToRoute('products_index');
    }

    /**
     * Creates a form to delete a Products entity.
     *
     * @param Products $product The Products entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Products $product)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('products_delete', array('id' => $product->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
