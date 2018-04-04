<?php
/**
 * Created by Drupai.
 * User: 烽行天下
 * Date: 2018\4\1 0001
 * Time: 16:49
 */

namespace AppBundle\Form\Type;


use AppBundle\Entity\Menu;
use AppBundle\Form\DataTransFormer\MenuToStringTransFormer;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MenuType extends AbstractType
{
    protected $manager;
    public function __construct(ObjectManager $manager){
        $this->manager = $manager;
    }

    public function configureOptions(OptionsResolver $resolver){
        $menus = $this->manager->getRepository(Menu::class)->findAll();
        $names = [];
        foreach ($menus as $menu){
            $name = $menu->getName();
            $names[$name] = $name;
        }
        $resolver->setDefaults(array(
            'choices' => $names,
            'placeholder' => '请选择一个父菜单',
        ));
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->addModelTransformer(new MenuToStringTransFormer($this->manager), true);
    }

    public function getParent()
    {
        return ChoiceType::class;
    }

}