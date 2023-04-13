<?php

namespace App\Form;

use App\Entity\Entreprise;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class EntrepriseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            //On rajoute TextType pour signaler qu'on veut un champ de text et on ajoute la class (clic droit -> ajouter class -> Component)
            ->add('raisonSociale', TextType::class, [
                'attr' => ['class' => 'form-control']
            ])
            //On rajoute DateType pour signaler qu'on veut une date et on ajoute la class (clic droit -> ajouter class -> Component)
            ->add('dateCreation', DateType::class, [
                'widget' => 'single_text',
                'attr' => ['class' => 'form-control']
            ])
            //On rajoute TextType pour signaler qu'on veut un champ de text et on ajoute la class (clic droit -> ajouter class -> Component)
            ->add('adresse', TextType::class, [
                'attr' => ['class' => 'form-control']
            ])
            //On rajoute TextType pour signaler qu'on veut un champ de text et on ajoute la class (clic droit -> ajouter class -> Component)
            ->add('cp', TextType::class, [
                'attr' => ['class' => 'form-control']
            ])
            //On rajoute TextType pour signaler qu'on veut un champ de text et on ajoute la class (clic droit -> ajouter class -> Component)
            ->add('ville', TextType::class, [
                'attr' => ['class' => 'form-control']
            ])
            //On rajoute TextType pour signaler qu'on veut un champ de text et on ajoute la class (clic droit -> ajouter class -> Component)
            ->add('siret', TextType::class, [
                'attr' => ['class' => 'form-control']
            ])
            //On rajoute TextType pour signaler qu'on veut un champ de text et on ajoute la class (clic droit -> ajouter class -> Component)
            ->add('submit', SubmitType::class, [
                //Pour ajouter un attr qui sera une classe
                'attr' => ['class' => 'btn btn-primary']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Entreprise::class,
        ]);
    }
}
