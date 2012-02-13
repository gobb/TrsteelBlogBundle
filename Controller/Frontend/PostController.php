<?php

namespace Trsteel\BlogBundle\Controller\Frontend;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PostController extends Controller
{
    public function indexAction()
    {
        $em     = $this->getDoctrine()->getEntityManager();
        $query  = $em->getRepository('TrsteelBlogBundle:Post')->getPostsWithCategoryQuery(true);
        
        $paginator = $this->get('knp_paginator');

        $posts = $paginator->paginate(
            $query,
            $this->get('request')->query->get('page', 1), #page number
            $this->container->getParameter('trsteel_blog.results_per_page') #limit per page
        );

        return $this->render('TrsteelBlogBundle:FrontEnd/Post:index.html.twig', array(
            'posts' => $posts
        ));
    }

    public function categoryAction($category_id)
    {   
        $em = $this->getDoctrine()->getEntityManager();
        
        if (!$category = $em->getRepository('TrsteelBlogBundle:Category')->find($category_id)) {
            throw $this->createNotFoundException('Unable to find Category.');
        }
        
        $query = $em->getRepository('TrsteelBlogBundle:Post')->getPostsByCategoryQuery($category_id, true);
        
        $paginator = $this->get('knp_paginator');

        $posts = $paginator->paginate(
            $query,
            $this->get('request')->query->get('page', 1), #page number
            $this->container->getParameter('trsteel_blog.results_per_page') #limit per page
        );
    
        return $this->render('TrsteelBlogBundle:FrontEnd/Post:category.html.twig', array(
            'category'  => $category,
            'posts'     => $posts
        ));
    }
    
    public function archiveAction($year, $month = null)
    {
        $em     = $this->getDoctrine()->getEntityManager();
        $query  = $em->getRepository('TrsteelBlogBundle:Post')->getPostsByYearMonth($year, $month);
        
        $paginator = $this->get('knp_paginator');

        $posts = $paginator->paginate(
            $query,
            $this->get('request')->query->get('page', 1), #page number
            10 #limit per page
        );
    
        return $this->render('TrsteelBlogBundle:FrontEnd/Post:index.html.twig', array(
            'posts'     => $posts
        ));
    }
    
    public function viewAction($post_id)
    {   
        $em     = $this->getDoctrine()->getEntityManager();

        $post   = $em->getRepository('TrsteelBlogBundle:Post')->getPostWithCategory($post_id, true);
        
        if (!$post) {
            throw $this->createNotFoundException('Unable to find Post.');
        }

        return $this->render('TrsteelBlogBundle:Frontend\Post:view.html.twig', array(
            'post' => $post,
        ));
    }

    public function panelCategoriesAction()
    {
        $em     = $this->getDoctrine()->getEntityManager();

        $must_have_posts    = $this->container->getParameter('trsteel_blog.panels.categories.must_have_posts');
        $show_post_count    = $this->container->getParameter('trsteel_blog.panels.categories.show_post_count');
        
        $categories         = $em->getRepository('TrsteelBlogBundle:Category')->getCategoryListQuery($must_have_posts, $show_post_count);

        return $this->render('TrsteelBlogBundle:Frontend/Panels:categories.html.twig', array(
            'categories'        => $categories,
            'show_post_count'   => $show_post_count,
        ));
    }

    public function panelArchiveAction()
    {
        $em     = $this->getDoctrine()->getEntityManager();

        $number_of_months   = $this->container->getParameter('trsteel_blog.panels.archive.number_of_months');
        $must_have_posts    = $this->container->getParameter('trsteel_blog.panels.archive.must_have_posts');
        $show_post_count    = $this->container->getParameter('trsteel_blog.panels.archive.show_post_count');
                        
        $months = $em->getRepository('TrsteelBlogBundle:Post')->getArchiveMonths(
            $number_of_months,
            $must_have_posts,
            $show_post_count
        );
    
        return $this->render('TrsteelBlogBundle:Frontend/Panels:archive.html.twig', array(
            'months'            => $months,
            'show_post_count'   => $show_post_count,
        ));
    }
}
