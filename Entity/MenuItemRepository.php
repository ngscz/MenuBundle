<?php

namespace Id4v\Bundle\MenuBundle\Entity;

use Gedmo\Sortable\Entity\Repository\SortableRepository;

/**
 * MenuItemRepository.
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class MenuItemRepository extends SortableRepository
{
    public function getRootNodesBySlug($slug)
    {
        $query = $this->createQueryBuilder('item')
                ->join('item.menu', 'menu')
                ->where("menu.slug LIKE '".$slug."'")
                ->andWhere('item.parent is null')
                ->orderBy('item.position', 'ASC');

        return $query->getQuery()->getResult();
    }
}
