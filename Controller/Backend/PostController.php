<?php

namespace Trsteel\BlogBundle\Controller\Backend;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Trsteel\BlogBundle\Entity\Post;
use Trsteel\BlogBundle\Form\PostType;

/**
* Post controller.
*
*/
class PostController extends Controller
{
    /**
    * Lists all Post entities.
    *
    */
    public function indexAction()
    {
        $em     = $this->getDoctrine()->getEntityManager();
        $repo    = $em->getRepository('TrsteelBlogBundle:Post');
        $query    = $repo->getPostsQuery();
        
        $paginator = $this->get('knp_paginator');

        $posts = $paginator->paginate(
            $query,
            $this->get('request')->query->get('page', 1), #page number
            10 #limit per page
        );   
    
        return $this->render('TrsteelBlogBundle:Backend/Post:index.html.twig', array(
            'posts' => $posts
        ));
    }

    /**
    * Displays a form to create a new Post.
    *
    */
    public function addAction()
    {
        $post = new Post();
        $request = $this->getRequest();
        $form   = $this->createForm(new PostType(), $post);

        if ("POST" == $request->getMethod()) {
            $form->bindRequest($request);
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($post);
                $em->flush();

                return $this->redirect(
                    $this->generateUrl(
                        'trsteel_blog_backend_post_index'
                    )
                );
            }    
        }

        return $this->render('TrsteelBlogBundle:Backend/Post:add.html.twig', array(
            'post'    => $post,
            'form'    => $form->createView()
        ));
    }

    /**
    * Displays a form to edit an existing Post.
    *
    */
    public function editAction($id)
    {
        $em     = $this->getDoctrine()->getEntityManager();
        $repo    = $em->getRepository('TrsteelBlogBundle:Post');       
        $post     = $repo->getPostWithCategory($id, null);

        if (!$post) {
            throw $this->createNotFoundException('Unable to find Post.');
        }

        $form = $this->createForm(new PostType(), $post);
        $request = $this->getRequest();

        if ("POST" == $request->getMethod()) {
            $form->bindRequest($request);
            if ($form->isValid()) {
                $em->persist($post);
                $em->flush();

                return $this->redirect(
                    $this->generateUrl(
                        'trsteel_blog_backend_post_index'
                    )
                );
            }    
        }

        return $this->render('TrsteelBlogBundle:Backend\Post:edit.html.twig', array(
            'post'          => $post,
            'form'            => $form->createView(),
        ));
    }

    /**
    * Deletes a Post.
    *
    */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $post = $em->getRepository('TrsteelBlogBundle:Post')->find($id);

        if (!$post) {
            throw $this->createNotFoundException('Unable to find Post.');
        }

        $em->remove($post);
        $em->flush();

        return $this->redirect($this->generateUrl('trsteel_blog_backend_post_index'));
    }
}
