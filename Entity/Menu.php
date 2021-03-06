<?php

namespace Id4v\Bundle\MenuBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Menu.
 *
 * @ORM\Table("menu__menu")
 * @ORM\Entity(repositoryClass="Id4v\Bundle\MenuBundle\Entity\MenuRepository")
 */
class Menu
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(name="slug", type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\OneToMany(targetEntity="MenuItem", mappedBy="menu", cascade={"persist","remove","merge"}, orphanRemoval=true)
     * @ORM\OrderBy({ "depth" = "ASC","position" = "ASC" })
     */
    private $items;

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return Menu
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set slug.
     *
     * @param string $slug
     *
     * @return Menu
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug.
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->items = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add items.
     *
     * @param \Id4v\Bundle\MenuBundle\Entity\MenuItem $items
     *
     * @return Menu
     */
    public function addItem(\Id4v\Bundle\MenuBundle\Entity\MenuItem $item)
    {
        $item->setMenu($this);
        $this->items[] = $item;

        return $this;
    }

    /**
     * Remove items.
     *
     * @param \Id4v\Bundle\MenuBundle\Entity\MenuItem $items
     */
    public function removeItem(\Id4v\Bundle\MenuBundle\Entity\MenuItem $items)
    {
        $this->items->removeElement($items);
    }

    /**
     * Get items.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getItems()
    {
        return $this->items;
    }

    public function __toString()
    {
        return $this->name.'';
    }

    public function getFirstLevelItems($activeOnly = true)
    {
        $retour = array();
        foreach ($this->getItems() as $item) {
            if ($item->getDepth() == 1) {
                if ($activeOnly && $item->isActive()) {
                    $retour[] = $item;
                }
            }
        }

        return $retour;
    }
}
