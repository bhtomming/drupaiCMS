<?php
/**
 * Created by Drupai.
 * User: 烽行天下
 * Date: 2018\3\31 0031
 * Time: 16:35
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
trait Page
{
    /**
     *
     * @ORM\Column(name="keywords", type="string", length=100, nullable=true)
     */
    protected $keywords;

    /**
     *
     * @ORM\Column(name="description", type="string", length=180, nullable=true)
     */
    protected $description;

    /**
     * @ORM\Column(name="view_counter", type="integer", nullable=true)
     */
    protected $viewCounter;

    /**
     *
     * @ORM\Column(name="is_front", type="boolean")
     */
    protected $isFront;

    public function setKeywords($keywords){
        $this->keywords = $keywords;
        return $this;
    }
    public function setDescription($description){
        $this->description = $description;
        return $this;
    }

    public function getKeywords(){
        return $this->keywords;
    }

    public function getDescription(){
        return $this->description;
    }

    public function setViewCounter($counter = 0){
        $this->viewCounter = $counter;
        return $this;
    }

    public function getViewCounter(){
        return $this->viewCounter;
    }

    public function setIsFront($isFront = true){
        $this->isFront = $isFront;
        return $this;
    }

    public function getIsFront(){
        return $this->isFront;
    }

    public function __construct(){
        $this->setViewCounter();
        $this->setIsFront();
    }

}