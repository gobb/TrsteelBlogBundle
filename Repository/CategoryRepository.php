<?php

namespace Trsteel\BlogBundle\Repository;

use Doctrine\ORM\EntityRepository;

class CategoryRepository extends EntityRepository
{
    public function getCategoryListQuery($must_have_posts = true, $get_post_count = true)
    {
        $qb = $this->createQueryBuilder('c');
        
        if ($must_have_posts || $get_post_count) {
            $qb->addSelect('
                (
                    SELECT count(p2.id) from TrsteelBlogBundle:Post p2
                    INNER JOIN p2.category c2
                    WHERE c2.id = c.id and p2.date <= :now and p2.is_enabled = 1
                ) as post_count
            ')
            ->setParameter('now', new \DateTime());
        }
        
        if ($must_have_posts) {
            $qb->andHaving('post_count > 0');
        }
        
        $qb->orderBy('c.title', 'ASC');
        
        $categories = array();
        foreach($qb->getQuery()->getResult() as $result) {
            $categories[] = array(
                'category' => is_array($result) ? $result[0] : $result,
                'post_count' => is_array($result) && isset($result['post_count']) ? $result['post_count'] : 0,
            );
        }
        
        return $categories;
    }
}