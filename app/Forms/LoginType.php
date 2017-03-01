<?php namespace App\Form;

use App\Models\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Validator\Constraints as Assert;

class LoginType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->setAction('/users/login')
            ->add('username', TextType::class,
                ['constraints' => [new Assert\Length(['min' => 4])], 'error_bubbling' => true])

            ->add('password', PasswordType::class,
                ['constraints' => [new Assert\NotBlank()],'error_bubbling' => true]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => User::class,
        ));
    }
}