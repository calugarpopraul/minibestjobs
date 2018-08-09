<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 8/9/18
 * Time: 9:50 AM
 */

namespace App\Form;

use Symfony\Bridge\Doctrine\Tests\Fixtures\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormTypeInterface;

class UserRegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('email',EmailType::class,
                [
                    'attr'=>[
                        'id'=>'email',
                        'placeholder'=>'Email'
                    ],
                'label'=>false,
                'invalid_message' => 'email in use'
            ])
            ->add('password',PasswordType::class,[
                'attr'=>[
                    'id'=>'password',
                    'placeholder'=>'Password'
                ],
                'label'=>false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class'=> 'App\Entity\User',
        ));
    }

}