<?php

namespace App\Form;

use App\Entity\Member;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MemberType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', TextType::class, ["label" => "Prénom: "])
            ->add('lastName', TextType::class, ["label" => "Nom: "])
            ->add('birthDay', BirthdayType::class, ['label' => 'Date de naissance', 'placeholder' => [
                'year' => 'Année', 'month' => 'Mois', 'day' => 'Jour'], 'format' => 'dd-MM-yyyy'])
            ->add('phone', TelType::class, ["label" => "Numéro de téléphone: ", 'attr' => ['maxlength' => 10]])
            ->add('email', EmailType::class, ['label' => 'Adresse email'])
            ->add('address', TextareaType::class, ['label' => 'Adresse'])
            ->add('zipCode', TextType::class, ["label" => "Code Postal: ", 'attr' => ['maxlength' => 5]])
            ->add('city', TextType::class, ["label" => "Ville: "])
            ->add('country', CountryType::class, [
                'data' => 'FR',
                'label' => 'Pays',
            ])
            ->add('otherAddressDetail', TextType::class, ["label" => "Complément d'adresse", "required"=> false])
            ->add('Suivant', SubmitType::class);

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Member::class,
        ]);
    }
}
