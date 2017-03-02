<?php namespace AppBundle\Form;

use AppBundle\Models\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Validator\Constraints as Assert;

class LoginType extends AbstractType
{

    /**
     * Build Login form
     *
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->setAction('/users/login')
            ->add('username', TextType::class, ['error_bubbling' => true])
            ->add('password', PasswordType::class,
                ['constraints' => [new Assert\NotBlank()],'error_bubbling' => true]
            )
        ;
    }

    /**
     * Configure Login form options
     *
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => User::class,
        ));
    }

    /**
     * Remove typeName prefixing for Login Authenticator
     *
     * @return null
     */
    public function getBlockPrefix() {
        return null;
    }
}