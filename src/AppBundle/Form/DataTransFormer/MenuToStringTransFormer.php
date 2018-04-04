<?php
/**
 * Created by Drupai.
 * User: 烽行天下
 * Date: 2018\4\1 0001
 * Time: 16:07
 */

namespace AppBundle\Form\DataTransFormer;

use AppBundle\Entity\Menu;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\DataTransformerInterface;
class MenuToStringTransFormer implements DataTransformerInterface
{
    protected $manager;

    public function __construct(ObjectManager $manager){
        $this->manager = $manager;
    }

    public function transform($object){
        //把对象转换成字符串
        if($object == null){
            return null;
        }
        return $object == null ? null : $object->getName();

    }

    public function reverseTransform($string)
    {
        //把字符串转换成对象
        if(null === $string || '' === $string){
            return null;
        }
        $name =  trim($string);

        $menu = $this->manager->getRepository(Menu::class)->findBy([
            'name' => $name,
        ]);
        if(empty($menu)){
            return null;
        }

        return $menu[0];
    }
}