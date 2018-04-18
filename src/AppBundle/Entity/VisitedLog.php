<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * VisitedLog
 *
 * @ORM\Table(name="visited_log")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\VisitedLogRepository")
 */
class VisitedLog
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
     * @ORM\Column(name="page", type="string", length=200)
     */
    private $page;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=100, nullable=true)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="comeFrom", type="string", length=100, nullable=true)
     */
    private $comeFrom;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="visitedTime", type="datetime")
     */
    private $visitedTime;

    /**
     * @var string
     *
     * @ORM\Column(name="userName", type="string", length=20)
     */
    private $userName;

    /**
     * @var string
     *
     * @ORM\Column(name="ipAddress", type="string", length=30)
     */
    private $ipAddress;


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
     * Set page
     *
     * @param string $page
     *
     * @return VisitedLog
     */
    public function setPage($page)
    {
        $this->page = $page;

        return $this;
    }

    /**
     * Get page
     *
     * @return string
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return VisitedLog
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
     * Set comeFrom
     *
     * @param string $comeFrom
     *
     * @return VisitedLog
     */
    public function setComeFrom($comeFrom)
    {
        $this->comeFrom = $comeFrom;

        return $this;
    }

    /**
     * Get comeFrom
     *
     * @return string
     */
    public function getComeFrom()
    {
        return $this->comeFrom;
    }

    /**
     * Set visitedTime
     *
     * @param \DateTime $visitedTime
     *
     * @return VisitedLog
     */
    public function setVisitedTime(\DateTime $visitedTime)
    {
        $this->visitedTime = $visitedTime;

        return $this;
    }

    /**
     * Get visitedTime
     *
     * @return \DateTime
     */
    public function getVisitedTime()
    {
        return $this->visitedTime;
    }

    /**
     * Set userName
     *
     * @param string $userName
     *
     * @return VisitedLog
     */
    public function setUserName($userName)
    {
        $this->userName = $userName;

        return $this;
    }

    /**
     * Get userName
     *
     * @return string
     */
    public function getUserName()
    {
        return $this->userName;
    }

    /**
     * Set ipAddress
     *
     * @param string $ipAddress
     *
     * @return VisitedLog
     */
    public function setIpAddress($ipAddress)
    {
        $this->ipAddress = $ipAddress;

        return $this;
    }

    /**
     * Get ipAddress
     *
     * @return string
     */
    public function getIpAddress()
    {
        return $this->ipAddress;
    }
}

