<?php

namespace Id4v\Bundle\MenuBundle\Builder;

use Doctrine\ORM\EntityManager;

class BaseMenuBuilder implements MenuBuilderInterface
{
  
    protected $factory;
    protected $em;
    /**
     * @param FactoryInterface $factory
     */
    public function __construct($factory = false, $em = false)
    {
        $this->factory = $factory;
        $this->em = $em;
    }
    protected function generateMenu($node, $items)
    {
        foreach ($items as $item) {
            $elem = $node->addChild($item->getTitle(), array(
                'uri' => $item->getUrl(),
                'linkAttributes' => array(
                    'target' => $item->getTarget(),
                ), )
            );
            if (!$item->isActive()) {
                $elem->setDisplay(false);
                $elem->setDisplayChildren(false);
            }
            if ($item->hasChildren()) {
                $this->generateMenu($node[$item->getTitle()], $item->getChildren());
            }
        }
    }
    protected function getSimpleMenu($slug)
    {
        $menu = $this->factory->createItem('root');
        $rootNodes = $this->getMenuNodes($slug);
        if (empty($rootNodes)) {
            return $menu;
        }
        $this->generateMenu($menu, $rootNodes);
        return $menu;
    }
    protected function getMenuNodes($slug)
    {
        return $this->getMenuRepository()->getRootNodesBySlug($slug);
    }
    protected function getMenuRepository()
    {
        return $this->em->getRepository('Id4vMenuBundle:MenuItem');
    }  
  
    public function buildMenu($node, $items)
    {
        foreach ($items as $item) {
            $elem = $node->addChild($item->getTitle(), array(
                'uri' => $item->getUrl(),
                'linkAttributes' => array(
                    'target' => $item->getTarget(),
                ), )
            );

            if (!$item->isActive()) {
                $elem->setDisplay(false);
                $elem->setDisplayChildren(false);
            }

            if ($item->hasChildren()) {
                $this->buildMenu($node[$item->getTitle()], $item->getChildren());
            }
        }

        return $node;
    }
}
