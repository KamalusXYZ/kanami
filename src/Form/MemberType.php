<?php

namespace App\Form;

use App\Entity\Member;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MemberType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName')
            ->add('lastName')
            ->add('birthday')
            ->add('phone')
            ->add('email')
            ->add('address')
            ->add('zipCode')
            ->add('city')
            ->add('country')
            ->add('otherAddressDetail')
            ->add('relationShip')
            ->add('memberEvent')
            ->add('MemberDailySession')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Member::class,
        ]);
    }
}
