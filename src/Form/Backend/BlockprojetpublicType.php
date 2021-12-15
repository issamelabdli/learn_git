<?php

namespace App\Form\Backend;

use App\Entity\Projet\Blockproject;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Vich\UploaderBundle\Form\Type\VichImageType;
 
use App\Form\Field\CKEditorField;

use FOS\CKEditorBundle\Form\Type\CKEditorType;

class BlockprojetpublicType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre')
            ->add('direction_image', ChoiceType::class, [
                'label' => 'Position Image',
                'choices'  => [
                    'Image a droit' => true,
                    'Image a goche' => false
                ],
            ])
            ->add('imageFile', VichImageType::class, [
                'required' => false,
                'allow_delete' => true,
                'download_uri' => true,
                'image_uri' => true,
            ]) 
            ->add('contenu', CKEditorType::class)
            ->add('position'); 
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Blockproject::class,
        ]);
    }
}
