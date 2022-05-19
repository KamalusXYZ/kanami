<?php

namespace App\Form;

use App\Entity\Item;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ItemType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, ["label" => "Nom: "])
            ->add('ref', TextType::class, ["label" => "Référence interne à la ludothèque: ",'required' => false])
            ->add('lang', TextType::class, ["label" => "Langue: ",'required' => false])
            ->add('publisherGameDuration',TextType::class, ["label" => "Durée d'une partie selon l'éditeur: ",'required' => false])
            ->add('ourGameDuration',TextType::class, ["label" => "Durée réelle d'une partie: ",'required' => false])
            ->add('playerNbMin', IntegerType::class,["label" => "Nombre de joueur minimum: ",'required' => false] )
            ->add('playerNbMax', IntegerType::class,["label" => "Nombre de joueur maximum: ",'required' => false])
            ->add('ageMin', IntegerType::class,["label" => "Age minimum conseillé par l'éditeur: ",'required' => false])
            ->add('author', TextType::class, ["label" => "Auteur: ",'required' => false])
            ->add('illustrator', TextType::class, ["label" => "Illustrateur: ",'required' => false])
            ->add('publisher', TextType::class, ["label" => "Editeur: ",'required' => false])
            ->add('itemCondition', TextType::class, ["label" => "Etat d'usure du jeu: ",'required' => false])
            ->add('completeness', CheckboxType::class, ["label" => "Cochez la case si le jeu est complet: ",'required' => false] )
            ->add('available', CheckboxType::class, ["label" => "Cochez la case si le jeu est disponible: ",'required' => false])
            ->add('gamePrice', TextType::class, ["label" => "Valeur en euro du jeu: ",'required' => false])
            ->add('gameOrigin', TextType::class, ["label" => "Provenance: ",'required' => false])
            ->add('copyNumber', TextType::class, ["label" => "Remplir uniquement si le jeu est possédé en plusiers exemplaire, indiquez le numéro de l'exemplaire: ",'required' => false]);

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Item::class,

        ]);
    }
}
