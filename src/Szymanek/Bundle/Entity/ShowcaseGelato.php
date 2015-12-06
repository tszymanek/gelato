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
     * @ORM\ManyToOne(targetEntity="Gelato")
     */
    private $gelato;

    /**
     * @ORM\ManyToOne(targetEntity="Showcase")
     */
    private $showcase;

    /*
     * @ORM\Column(name="position", type="integer")
     */
    private $position;
}