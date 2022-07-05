<?php

namespace App\Form;

use App\Entity\Item;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class ItemType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, ["label" => "Nom complet du jeu:* ", 'attr' => ['class' => 'nameType']],
            )
            ->add('ref', TextType::class, ["label" => "Référence interne à la ludothèque: ", 'required' => false])
            ->add('lang', ChoiceType::class, [
                'choices' => [
                    'Français' => 'Français',
                    'Anglais' => 'Anglais',
                    'Allemand' => 'Allemand',
                    'Espagnol' => 'Espagnol',
                    'Italien' => 'Italien',
                    'Autre' => 'Autre',

                ],
                'preferred_choices' => ['Français'], "label" => "Langue principale: "
            ])
            ->add('publisherGameDuration', ChoiceType::class, [
                'choices' => [

                    'Moins de 15m' => "Moins de 15m",
                    'moins de 30m' => "moins de 30m",
                    'de 30m à 1h' => "de 30m à 1h",
                    'de 1h à 2h' => "de 1h à 2h",
                    'de 2h à 3h' => "de 2h à 3h",
                    'de 3h à 4h' => "de 3h à 4h",
                    'plus de 4h' => "plus de 4h",


                ], "label" => "Durée d'une partie selon l'éditeur: ", 'required' => false
            ])
            ->add('ourGameDuration', ChoiceType::class, [
                'choices' => [

                    'Moins de 15m' => "Moins de 15m",
                    'moins de 30m' => "moins de 30m",
                    'de 30m à 1h' => "de 30m à 1h",
                    'de 1h à 2h' => "de 1h à 2h",
                    'de 2h à 3h' => "de 2h à 3h",
                    'de 3h à 4h' => "de 3h à 4h",
                    'plus de 4h' => "plus de 4h",


                ], "label" => "Durée d'une partie selon l'estimation de la ludo: ", 'required' => false
            ])
            ->add('playerNbMin', IntegerType::class, ["label" => "Nombre de joueur minimum: ", 'required' => false,])
            ->add('playerNbMax', IntegerType::class, ["label" => "Nombre de joueur maximum: ", 'required' => false])
            ->add('ageMin', IntegerType::class, ["label" => "Age minimum conseillé par l'éditeur: ", 'required' => false])
            ->add('author', TextType::class, ["label" => "Auteur(s):  (si plusieurs séparez les par des virgules) ", 'required' => false])
            ->add('illustrator', TextType::class, ["label" => "Illustrateur(s):", 'required' => false])
            ->add('publisher', TextType::class, ["label" => "Éditeur: ", 'required' => false])
            ->add('itemCondition', ChoiceType::class, [
                'choices' => [

                    'A définir' => "A définir",
                    'Neuf' => "Neuf",
                    'Moyen' => "Moyen",
                    'Usé' => "Usé",
                    'Très usé' => "Très usé",

                ],
                'preferred_choices' => ['A définir'], "label" => "Etat d'usure du jeu: "
            ])
            ->add('completeness', CheckboxType::class, ['data' => true, "label" => "Complet?", 'required' => false])
            ->add('available', CheckboxType::class, ['data' => true, "label" => "Disponible?", 'required' => false])
            ->add('gamePrice', IntegerType::class, ["label" => "Valeur: ", 'required' => false])
            ->add('gameOrigin', TextType::class, ["label" => "Provenance: ", 'required' => false])
            ->add('copyNumber', IntegerType::class, ["label" => "Remplir uniquement si le jeu est possédé en plusieurs exemplaire, indiquez le numéro de l'exemplaire: ", 'required' => false])
            ->add('Suivant', SubmitType::class);

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Item::class,

        ]);
    }
}
