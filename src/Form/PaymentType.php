<?php

namespace App\Form;

use App\Entity\Payment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PaymentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('paymentDate', HiddenType::class)
            ->add('paymentKind', ChoiceType::class, [
                'choices' => [

                    'Carte bancaire' => "cb",
                    'Chèque' => "cheque",
                    'Espèce' => "espece",
                    'Autre' => "autre",
                    'Payez plus tard' => "aucun paiement",

                ],"label" => "Choisissez le mode de paiement: ", 'required' => true
            ])
            ->add('paymentAmount', HiddenType::class)
            ->add('paymentComment', TextareaType::class, ["label" => "Commentaire: ", 'required' => false,
                'empty_data' => 'Aucun commentaire'])
            ->add('family', HiddenType::class)
            ->add('Confirmer', SubmitType::class)
            ->add('toylibrary', HiddenType::class);

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Payment::class,
        ]);
    }
}
