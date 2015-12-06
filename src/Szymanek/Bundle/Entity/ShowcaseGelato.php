<?php

namespace Szymanek\Bundle\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
*/
class ShowcaseGelato
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
     * @ORM\ManyToOne(targetEntity="Gelato", fetch="EAGER")
     */
    private $gelato;

    /**
     * @ORM\ManyToOne(targetEntity="Showcase", inversedBy="gelatos")
     * @ORM\JoinColumn(name="showcase_id", referencedColumnName="id")
     */
    private $showcase;

    /**
     * @ORM\Column(name="position", type="integer")
     */
    private $position;

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return integer
     */
    public function getPosition(){
        return $this->position;
    }

    /**
     * @return mixed
     */
    public function getShowcase(){
        return $this->showcase;
    }
}