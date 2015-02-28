<?php

namespace Overscan\Bundle\MenuBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Overscan\Bundle\MenuBundle\Entity\MenuItem;

class MenuAdmin extends Admin
{

    protected $baseRoutePattern = 'menu';

    /**
     * @param RouteCollection $collection
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('organize', $this->getRouterIdParameter().'/organiser');
        $collection->add('addItem',$this->getRouterIdParameter().'/add_item');
        $collection->add('updateItems',$this->getRouterIdParameter().'/update_items');
        $collection->add('editItem',$this->getRouterIdParameter().'/edit_item');
        $collection->add('deleteItem',$this->getRouterIdParameter().'/delete_item');
    }


    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('name')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'arrange'=> array(
                        "template"=>"OverscanMenuBundle:CRUD:list__action_arrange.html.twig"
                    ),
                    'edit' => array(),
                    'delete' => array(),
                )
            ))
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('name',null,array("label"=>"Nom du menu"))
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('name')
            ->add('slug')
        ;
    }

/*    public function create($object)
    {

        $retour=parent::create($object);

        $em=$this->getConfigurationPool()->getContainer()->get("doctrine")->getEntityManagerForClass("OverscanMenuBundle:MenuItem");

        $menuItem = new MenuItem();
        $menuItem->setTitle("Racine");
        $menuItem->setActive(false);
        $menuItem->setUrl("#");

        $menuItem->setMenu($object);

        $em->persist($menuItem);
        $em->flush();

        return $retour;
    }*/


}