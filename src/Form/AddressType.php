<?php

namespace App\Form;

use App\Entity\Address;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('addressName', null, [
                'label' => 'Nom de l\'adresse (Ex: Maison)'
            ])
            ->add('firstname', null, [
                'label' => 'Prénom'
            ])
            ->add('lastname', null, [
                'label' => 'Nom de famille'
            ])
            ->add('address', null, [
                'label' => 'Adresse'
            ])
            ->add('zipCode', null, [
                'label' => 'Code postal'
            ])
            ->add('city', null, [
                'label' => 'Ville'
                ])
            ->add('country', CountryType::class, [
                'label' => 'Pays'
            ])
            ->add('phone', null, [
                'label' => 'Téléphone'
            ])
            ->add('submit', SubmitType::class, [
                "label" => "Valider"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
        ]);
    }
}
