<?php

namespace Trsteel\BlogBundle\Controller\Backend;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Trsteel\BlogBundle\Entity\Category;
use Trsteel\BlogBundle\Form\CategoryType;

/**
* Category controller.
*
*/
class CategoryController extends Controller
{
    /**
    * Lists all Category entities.
    *
    */
    public function indexAction()
    {
        $em         = $this->getDoctrine()->getEntityManager();
        $categories = $em->getRepository('TrsteelBlogBundle:Category')->findAll();

        return $this->render('TrsteelBlogBundle:Backend/Category:index.html.twig', array(
            'categories' => $categories
        ));
    }

    /**
    * Displays a form to create a new Category.
    *
    */
    public function addAction()
    {
        $category   = new Category();
        $request    = $this->getRequest();
        $form       = $this->createForm(new CategoryType(), $category);

        if ("POST" == $request->getMethod()) {
            $form->bindRequest($request);
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($category);
                $em->flush();

                return $this->redirect(
                    $this->generateUrl(
                        'trsteel_blog_backend_category_index'
                    )
                );
            }    
        }

        return $this->render('TrsteelBlogBundle:Backend/Category:add.html.twig', array(
            'category'    => $category,
            'form'      => $form->createView()
        ));
    }

    /**
    * Displays a form to edit an existing Category.
    *
    */
    public function editAction($id)
    {
        $em         = $this->getDoctrine()->getEntityManager();
        $category   = $em->getRepository('TrsteelBlogBundle:Category')->find($id);

        if (!$category) {
            throw $this->createNotFoundException('Unable to find Category.');
        }

        $form       = $this->createForm(new CategoryType(), $category);
        $request    = $this->getRequest();

        if ("POST" == $request->getMethod()) {
            $form->bindRequest($request);

            if ($form->isValid()) {
                $em->persist($category);
                $em->flush();

                return $this->redirect(
                    $this->generateUrl(
                        'trsteel_blog_backend_category_index'
                    )
                );
            }    
        }

        return $this->render('TrsteelBlogBundle:Backend\Category:edit.html.twig', array(
            'category'    => $category,
            'form'        => $form->createView(),
        ));
    }

    /**
    * Deletes a Category.
    *
    */
    public function deleteAction($id)
    {
        $em         = $this->getDoctrine()->getEntityManager();
        $category   = $em->getRepository('TrsteelBlogBundle:Category')->find($id);

        if (!$category) {
            throw $this->createNotFoundException('Unable to find Category.');
        }

        $em->remove($category);
        $em->flush();

        return $this->redirect($this->generateUrl('trsteel_blog_backend_category_index'));
    }
}
