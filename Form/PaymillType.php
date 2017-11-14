<?php

namespace Memeoirs\PaymillBundle\Form;

use Symfony\Component\Form\AbstractType,
    Symfony\Component\Form\FormBuilderInterface,
    Symfony\Component\OptionsResolver\OptionsResolverInterface,
    Symfony\Component\Validator\Constraints\NotBlank,
    Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class PaymillType extends AbstractType
{
    private $translator;

    public function __construct($translator)
    {
        $this->translator = $translator;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $tokenNotBlank = new NotBlank(array(
            'message' => $this->translator->trans('default', array(), 'errors')
        ));

        $builder
            ->add('number' , TextType::class,   array('required' => true, 'label' => 'Card number'))
            ->add('expiry' , TextType::class,   array('required' => true, 'label' => 'Expires'))
            ->add('holder' , TextType::class,   array('required' => true, 'label' => 'Name on card'))
            ->add('cvc'    , TextType::class,   array('required' => true, 'label' => 'Card code'))
            ->add('token'  , HiddenType::class, array(
                'required' => true,
                'constraints' => array($tokenNotBlank)
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'validation_groups' => function(FormInterface $form) {
                $data = $form->getParent()->getData();

                // Perform validation only if the payment method is Paymill
                return $data->getPaymentSystemName() === $this->getName()
                    ? array('Default')
                    : array();
            }
        ));
    }

    public function getName()
    {
        return 'paymill';
    }
}