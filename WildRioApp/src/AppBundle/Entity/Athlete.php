<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Athlete
 *
 * @ORM\Table(name="athlete")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AthleteRepository")
 */
class Athlete
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
     * @var int
     *
     * @ORM\Column(name="idepreuve", type="integer", nullable=true)
     */
    private $idepreuve;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255, nullable=true)
     */
    private $nom;

    /**
     * @var int
     *
     * @ORM\Column(name="vote", type="integer", nullable=true)
     */
    private $vote;

    /**
     * @var int
     *
     * @ORM\Column(name="percent", type="integer", nullable=true)
     */
    private $percent;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set idepreuve
     *
     * @param integer $idepreuve
     * @return Athlete
     */
    public function setIdepreuve($idepreuve)
    {
        $this->idepreuve = $idepreuve;

        return $this;
    }

    /**
     * Get idepreuve
     *
     * @return integer 
     */
    public function getIdepreuve()
    {
        return $this->idepreuve;
    }

    /**
     * Set nom
     *
     * @param string $nom
     * @return Athlete
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string 
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set vote
     *
     * @param integer $vote
     * @return Athlete
     */
    public function setVote($vote)
    {
        $this->vote = $vote;

        return $this;
    }

    /**
     * Get vote
     *
     * @return integer 
     */
    public function getVote()
    {
        return $this->vote;
    }

    /**
     * Set percent
     *
     * @param integer $percent
     * @return Athlete
     */
    public function setPercent($percent)
    {
        $this->percent = $percent;

        return $this;
    }

    /**
     * Get percent
     *
     * @return integer 
     */
    public function getPercent()
    {
        return $this->percent;
    }
}
