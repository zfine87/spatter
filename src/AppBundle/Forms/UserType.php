<?php namespace AppBundle\Form;

use AppBundle\Models\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Validator\Constraints as Assert;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class,
                ['constraints' => [new Assert\Email()], 'error_bubbling' => true])

            ->add('username', TextType::class,
                ['constraints' => [new Assert\Length(['min' => 4])], 'error_bubbling' => true])

            ->add('plainPassword', RepeatedType::class, array(
                'error_bubbling' => true,
                'type'           => PasswordType::class,
                'first_options'  => ['label' => 'Password'],
                'second_options' => ['label' => 'Repeat Password'],
                'constraints'    => [new Assert\Length(['min' => 5])]
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => User::class,
            'error_bubbling' => true
        ));
    }
}