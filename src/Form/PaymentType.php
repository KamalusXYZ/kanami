<?php

namespace App\Form;

use App\Entity\Payment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PaymentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('paymentDate', HiddenType::class)
            ->add('paymentKind', ChoiceType::class, [
                'choices'  => [
                    'Selectionnez un mode de paiement' => null ,
                    'Carte bancaire' => "cb",
                    'Chèque' => "cheque",
                    'Espèce' => "espece",
                    'Autre' => "autre",
                ],
            ])
            ->add('paymentAmount', MoneyType::class, ["label" => "Montant: "])
        ->add('paymentComment', TextareaType::class, ["label" => "Commentaire: ",'required'   => false,
            'empty_data' => 'Aucun commentaire'])
        ->add('family', HiddenType::class)
        ->add('toylibrary', HiddenType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Payment::class,
        ]);
    }
}
