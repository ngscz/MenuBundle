<?php

namespace Id4v\Bundle\MenuBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;

class MenuItemAdmin extends Admin
{
    protected $parentAssociationMapping = 'menu';

    protected $datagridValues = array(

        // display the first page (default = 1)
        '_page' => 1,

        // reverse order (default = 'ASC')
        '_sort_order' => 'ASC',

        // name of the ordered field (default = the model's id field, if any)
        '_sort_by' => 'position',
    );

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('updateItem', $this->getRouterIdParameter().'/updateItem', array(), array(), array('expose' => true));
        parent::configureRoutes($collection);
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('title')
            ->add('url')
            ->add('active')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->add('title')
            ->add('url')
            ->add('active')
            ->add('target')
            ->add('position')
            ->add('depth')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                ),
            ))
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
      $formMapper
          ->add('title', null, array(
              'label' => 'menu.item.title',
          ))
          ->add('url', null, array(
              'label' => 'menu.item.url',
          ))
          ->add('active', null, array(
              'label' => 'menu.item.active',
              'required' => false,
          ))
          ->add('target', 'choice', array(
              'label' => 'menu.item.target',
              'choices_as_values' => true,
              'translation_domain'=>$this->getTranslationDomain(),
              'choices' => array(
                  'menu.menu_item.same_window'=>'_self',
                  'menu.menu_item.new_window'=>'_target',
              ),
          ))
      ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('title')
            ->add('url')
            ->add('active')
            ->add('target')
            ->add('position')
            ->add('depth')
        ;
    }

    public function getTemplate($name)
    {
        if ($name == 'list') {
            return 'Id4vMenuBundle:CRUD:list_tree.html.twig';
        }
        if ($name == 'delete') {
            return 'Id4vMenuBundle:CRUD:delete.html.twig';
        }

        return parent::getTemplate($name);
    }
}
