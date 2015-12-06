<?php

namespace Szymanek\Bundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/** @ORM\Entity **/
class Showcase
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string")
     */
    private $name;

    /**
     * @var integer
     *
     * @ORM\Column(name="capacity", type="integer")
     */
    private $capacity;

    /** @ORM\OneToMany(targetEntity="ShowcaseGelato", mappedBy="showcase", fetch="EAGER")
     * @ORM\OrderBy({"position" = "ASC"}) **/
    private $gelatos;

    public function __construct()
    {
        $this->gelatos = new ArrayCollection();
    }

//    public function sortGelatosByPosition()
//    {
//        $unsortedGelatos = $this->gelatos;
//        $sortedGelatos = new ArrayCollection();
//        foreach($unsortedGelatos as $key => $value){
//            $sortedGelatos->set((integer)$unsortedGelatos->get($key)->getPosition(), $unsortedGelatos->get($key));
//        }
//        $this->gelatos = $sortedGelatos;
//        return $this;
//    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getGelatos()
    {
        return $this->gelatos;
    }

    /**
     * @param $gelatos
     * @return $this
     */
    public function setGelatos($gelatos)
    {
        $this->gelatos = $gelatos;
        return $this;
    }

    /**
     * @return integer
     */
    public function getCapacity(){
        return $this->capacity;
    }
}