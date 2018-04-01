<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SiteBuild
 *
 * @ORM\Table(name="site_build")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SiteBuildRepository")
 */
class SiteBuild
{
    use Page;
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
     * @ORM\Column(name="site_type", type="string", length=255)
     */
    private $siteType;

    /**
     * @var string
     *
     * @ORM\Column(name="site_pic", type="string", nullable=true)
     */
    private $sitePic;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float")
     */
    private $price;

    /**
     * @var string
     *
     * @ORM\Column(name="cycle", type="string", length=100)
     */
    private $cycle;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set siteType
     *
     * @param string $siteType
     *
     * @return SiteBuild
     */
    public function setSiteType($siteType)
    {
        $this->siteType = $siteType;

        return $this;
    }

    /**
     * Get siteType
     *
     * @return string
     */
    public function getSiteType()
    {
        return $this->siteType;
    }

    /**
     * Set price
     *
     * @param float $price
     *
     * @return SiteBuild
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set cycle
     *
     * @param string $cycle
     *
     * @return SiteBuild
     */
    public function setCycle($cycle)
    {
        $this->cycle = $cycle;

        return $this;
    }

    /**
     * Get cycle
     *
     * @return string
     */
    public function getCycle()
    {
        return $this->cycle;
    }

    /**
     * Set sitePic
     *
     * @param string $sitePic
     *
     * @return SiteBuild
     */
    public function setSitePic($sitePic)
    {
        $this->sitePic = $sitePic;

        return $this;
    }

    /**
     * Get sitePic
     *
     * @return string
     */
    public function getSitePic()
    {
        return $this->sitePic;
    }
}
