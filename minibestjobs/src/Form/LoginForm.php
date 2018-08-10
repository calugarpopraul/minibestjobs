<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 8/10/18
 * Time: 10:01 AM
 */

namespace App\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;

class LoginForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('_username')
            ->add('_password',PasswordType::class)
            ;
    }

}