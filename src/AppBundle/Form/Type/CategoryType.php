<?php
/**
 * Created by Drupai.
 * User: 烽行天下
 * Date: 2018\3\18 0018
 * Time: 9:58
 */

namespace AppBundle\Form\Type;


use AppBundle\Entity\Category;
use AppBundle\Form\DataTransFormer\CategoryArrayToStringTransFormer;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bridge\Doctrine\Form\DataTransformer\CollectionToArrayTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;

class CategoryType extends AbstractType
{
    protected $manager;

    public function __construct(ObjectManager $manager){
        $this->manager = $manager;
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['categories'] = $this->manager->getRepository(Category::class)->findAll();
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->addModelTransformer(new CollectionToArrayTransformer(),true)
            ->addModelTransformer(new CategoryArrayToStringTransFormer($this->manager), true);
    }

    public function getParent()
    {
        return TextType::class;
    }

}