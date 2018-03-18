<?php
/**
 * Created by Drupai.
 * User: 烽行天下
 * Date: 2018\3\18 0018
 * Time: 9:42
 */

namespace AppBundle\Form\DataTransFormer;


use AppBundle\Entity\Category;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\DataTransformerInterface;

class CategoryArrayToStringTransFormer implements DataTransformerInterface
{
    protected $manager;

    public function __construct(ObjectManager $manager){
        $this->manager = $manager;
    }

    public function transform($array){
        //把数据转换成字符串
        return implode(',',$array);

    }

    public function reverseTransform($string)
    {
        //把字符串转换成数组
        if(null === $string || '' === $string){
            return [];
        }
        $names = array_filter(array_unique(array_map('trim',explode(',',$string))));

        $tags = $this->manager->getRepository(Category::class)->findBy([
            'title' => $names
        ]);

        $newName = array_diff($names,$tags);

        foreach ($newName as $name){
            $tag = new Category();
            $tag->setTitle($name);
            $tags[] = $tag;
        }

        return $tags;
    }

}