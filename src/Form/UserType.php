<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class, ['label'=> 'Votre prénom'])
            ->add('lastName', TextType::class, ['label'=> 'Votre Nom'])
            ->add('level', IntegerType::class, ['label'=> 'Index',
            'required'=> false])
            ->add('sexe', ChoiceType::class,[
                'choices' => [
                    'Femme' => true,
                    'Homme' => false]])
            ->add('email', TextType::class,['label'=> 'Votre mail',
                'invalid_message' => 'Votre mail doit comporter un @'])
            ->add('club', TextType::class,['label'=> 'Adhérent au club de...',
                'required'=> false])
            ->add('dateBirth',DateType::class,[
                'widget'=>'single_text'])
            ->add('phone', TextType::class, ['label'=> 'Votre téléphone',
                'invalid_message' => 'Le numéro doit comporter %num% chiffres',
                'invalid_message_parameters' => ['%num%' => 10],
                'required'=> false])
            ->add('password', TextType::class,['label'=> 'Mot de passe',
                'invalid_message' => 'doit comporter au minimum %num% carractères',
                'invalid_message_parameters' => ['%num%' => 6]])
            ->add('pseudo', TextType::class, ['label'=> 'Choisir un pseudo'])
            ->add('creditDuration', IntegerType::class, ['label'=> 'Credit de cours'])
            ->add('submit', SubmitType::class, ['label'=>'Valider'])
            // Je rajoute manuellemet un input 'submit'
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
