<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 8/7/18
 * Time: 2:42 PM
 */

namespace App\Form;

use App\Model\JobSearch;
use function Sodium\add;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class JobSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('keyword',TextType::class,
            [
                'attr'=>[
                    'id'=>'key',
                    'placeholder'=>'Cuvant cheie'
                ],
                'label'=>false,
            ]);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver); // TODO: Change the autogenerated stub
    }
}