<?php

namespace App\Form;

use App\Entity\CategoryDependance;
use App\Entity\Item;
use Doctrine\DBAL\Types\SimpleArrayType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ItemType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, ["label"=>"Nom"])
            ->add('ref')
            ->add('lang')
            ->add('publisherGameDuration')
            ->add('ourGameDuration')
            ->add('playerNbMin')
            ->add('playerNbMax')
            ->add('ageMin')
            ->add('author')
            ->add('illustrator')
            ->add('publisher')
            ->add('itemCondition')
            ->add('completeness')
            ->add('available')
            ->add('archive')
            ->add('updatePseudoUser')
            ->add('UpdateDateTime')
            ->add('archivePseudoUser')
            ->add('archiveDateTime')
            ->add('archiveCause')
            ->add('archiveGameBecome')
            ->add('memberItemRatingTotal')
            ->add('memberItemRatingNb')
            ->add('gamePrice')
            ->add('gameOrigin')
            ->add('userMadeEntry')
            ->add('copyNumber')
            ->add('registerDateTime')
            ->add('tags')

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Item::class,

        ]);
    }
}
