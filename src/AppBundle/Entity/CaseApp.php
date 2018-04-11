<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;

/**
 * Caseapp
 *
 * @ORM\Table(name="caseapp")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CaseAppRepository")
 * @Vich\Uploadable
 */
class CaseApp
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
     * @ORM\Column(name="site_name", type="string", length=100)
     */
    private $siteName;

    /**
     * @var string
     *
     * @ORM\Column(name="site_pic", type="string", nullable=true)
     */
    private $sitePic;

    /**
     * @Vich\UploadableField(mapping="case_images", fileNameProperty="site_pic")
     * @var File
     */
    private $imageFile;

    /**
     * @var string
     *
     * @ORM\Column(name="site_link", type="string", length=50)
     */
    private $siteLink;

    /**
     * @var string
     *
     * @ORM\Column(name="details", type="text", nullable=true)
     */
    private $details;


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
     * Set siteName
     *
     * @param string $siteName
     *
     * @return CaseApp
     */
    public function setSiteName($siteName)
    {
        $this->siteName = $siteName;

        return $this;
    }

    /**
     * Get siteName
     *
     * @return string
     */
    public function getSiteName()
    {
        return $this->siteName;
    }

    /**
     * Set siteLink
     *
     * @param string $siteLink
     *
     * @return CaseApp
     */
    public function setSiteLink($siteLink)
    {
        $this->siteLink = $siteLink;

        return $this;
    }

    /**
     * Get siteLink
     *
     * @return string
     */
    public function getSiteLink()
    {
        return $this->siteLink;
    }

    /**
     * Set details
     *
     * @param string $details
     *
     * @return CaseApp
     */
    public function setDetails($details)
    {
        $this->details = $details;

        return $this;
    }

    /**
     * Get details
     *
     * @return string
     */
    public function getDetails()
    {
        return $this->details;
    }

    /**
     * Set sitePic
     *
     * @param string $sitePic
     *
     * @return CaseApp
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

    public function getImageFile(){
        return $this->imageFile;
    }

    public function setImageFile(File $image = null){
        $this->imageFile = $image;
    }
}
