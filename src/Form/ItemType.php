<?php

namespace App\Form;

use App\Entity\Item;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ItemType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Item::class,
        ]);
    }
}
