<?php

namespace Trsteel\BlogBundle\Repository;

use Doctrine\ORM\EntityRepository;

class PostRepository extends EntityRepository
{
    
    public function getPostsByCategoryQuery($category_id, $is_active = true)
    {
        $qb = $this->createQueryBuilder('p')
                    ->leftJoin('p.category', 'cIdSearch')
                    ->andwhere('cIdSearch.id = :category_id')->setParameter('category_id', $category_id)
                    ->orderBy('p.date', 'DESC')
                    ->addOrderBy('p.id', 'DESC')
        ;
        
        $qb = $this->isActive($qb, $is_active);
        $qb = $this->attachCategories($qb);
        
        return $qb->getQuery();
    }
    
    public function getPostsByYearMonth($year, $month = null)
    {
        if ($month) {
            $from = new \DateTime($year.'-'.$month.'-01 00:00:00');
            $to = clone($from);
            $to = $to->modify('last day of this month 23:59:59');
        }
        else {
            $from = new \DateTime($year.'-01-01 00:00:00');
            $to = new \DateTime($year.'-12-31 23:59:59');
        }
        
        $qb = $this->createQueryBuilder('p')
                    ->andWhere('p.date >= :from')->setParameter('from', $from)
                    ->andWhere('p.date <= :to')->setParameter('to', $to)
                    ->orderBy('p.date', 'DESC')
                    ->addOrderBy('p.id', 'DESC')
        ;
        
        $qb = $this->isActive($qb, true);
        $qb = $this->attachCategories($qb);
        
        return $qb->getQuery();
    }
    
    public function getPostWithCategory($post_id, $is_active = true)
    {
        $qb = $this->createQueryBuilder('p')
                    ->andWhere('p.id = :post_id')->setParameter('post_id', $post_id)
                    ->orderBy('p.date', 'DESC')
                    ->addOrderBy('p.date', 'DESC')
        ;
        
        $qb = $this->isActive($qb, $is_active);
        $qb = $this->attachCategories($qb);
        
        try {
            $post = $qb->getQuery()->getSingleResult();
        } catch (\Doctrine\Orm\NoResultException $e) {
            $post = null;
        }
        
        return $post;
    }
    
    public function getPostsQuery()
    {
        $qb = $this->createQueryBuilder('p')
                    ->orderBy('p.date', 'DESC')
                    ->addOrderBy('p.date', 'DESC')
        ;
        
        return $qb->getQuery();
    }
    
    public function getPostsWithCategoryQuery($is_active = true)
    {
        $qb = $this->createQueryBuilder('p')
                    ->orderBy('p.date', 'DESC')
                    ->addOrderBy('p.id', 'DESC')
        ;
        
        $qb = $this->isActive($qb, $is_active);
        $qb = $this->attachCategories($qb);   
        
        return $qb->getQuery();
    }
    
    public function getArchiveMonths($number_of_months, $must_have_posts, $show_post_count)
    {
        $from = new \DateTime('-'.$number_of_months.' months');
        $from->modify('first day of next month midnight');
        
        $to = new \DateTime('last day of this month 23:59:59');
        
        $current_month = clone($to);
        $months = array();
        while($current_month > $from) {
            $months[$current_month->format("Y-m")] = array(
                'date'            => clone($current_month),
                'post_count'    => 0,
            );
            $current_month->modify('-1 month');
        }

        //we only want to run the query if the month must have posts or we are showing the post count
        if ($must_have_posts || $show_post_count) {
            $qb = $this->createQueryBuilder('p');
            $qb = $this->isActive($qb, true);
            
            $qb->addSelect('count(p.id) as post_count')
                        ->addSelect("DATE_FORMAT(p.date, '%Y%m') as HIDDEN YearMonth")
                        
                        ->andWhere('p.date >= :from')
                        ->andWhere('p.date <= :to')
                        
                         ->groupBy("YearMonth")
    
                        ->setMaxResults($number_of_months)
                        
                        ->setParameter('now', new \DateTime())
                        ->setParameter('from', $from)
                        ->setParameter('to', $to)
            ;

            foreach($qb->getQuery()->getArrayResult() as $result) {
                $months[$result[0]['date']->format('Y-m')]['post_count'] = $result['post_count'];
            }
        }
        
        if ($must_have_posts) {
            foreach($months as $key => $val) {
                if ($val['post_count'] < 1) {
                    unset($months[$key]);
                }
            }
        }
        
        return array_values($months);
    }
    
    private function attachCategories(\Doctrine\ORM\QueryBuilder $qb)
    {
        return $qb->addSelect('c')
            ->leftJoin('p.category', 'c')
        ;
    }
    
    private function isActive(\Doctrine\ORM\QueryBuilder $qb, $is_active)
    {
        if (is_null($is_active)) {
            return $qb;
        }
        
        if ($is_active) {
            $qb->andWhere('(p.is_enabled = 1 AND p.date <= :now)');
        }
        else {
            $qb->andWhere('(p.is_enabled = 0 OR p.date > :now)');
        }
        
        $qb->setParameter('now', new \DateTime());

        return $qb;
    }

}