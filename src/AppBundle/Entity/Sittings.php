<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Sittings
 *
 * @ORM\Table(name="site_sittings")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SittingsRepository")
 */
class Sittings
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
     * @ORM\Column(name="title", type="string", length=200)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="slogan", type="string", length=255, nullable=true)
     */
    private $slogan;

    /**
     * @var string
     *
     * @ORM\Column(name="keywords", type="string", length=200, nullable=true)
     */
    private $keywords;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    private $description;


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
     * Set title
     *
     * @param string $title
     *
     * @return Sittings
     */
    public function setTitle($title)
    {
        $this->title = $title;
    
        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set slogan
     *
     * @param string $slogan
     *
     * @return Sittings
     */
    public function setSlogan($slogan)
    {
        $this->slogan = $slogan;
    
        return $this;
    }

    /**
     * Get slogan
     *
     * @return string
     */
    public function getSlogan()
    {
        return $this->slogan;
    }

    /**
     * Set keywords
     *
     * @param string $keywords
     *
     * @return Sittings
     */
    public function setKeywords($keywords)
    {
        $this->keywords = $keywords;
    
        return $this;
    }

    /**
     * Get keywords
     *
     * @return string
     */
    public function getKeywords()
    {
        return $this->keywords;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Sittings
     */
    public function setDescription($description)
    {
        $this->description = $description;
    
        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }
}

