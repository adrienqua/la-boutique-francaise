<?php

namespace App\Controller\Admin;

use App\Entity\Slider;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class SliderCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Slider::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            ImageField::new('image')->setBasePath('img/sliders/')->setUploadDir(('public/img/sliders/')),
            TextField::new('title', 'Titre'),
            TextField::new('subtitle', 'Sous titre'),
            TextField::new('buttonText', 'Texte bouton'),
            TextField::new('buttonLink', 'Lien bouton'),
            BooleanField::new('isActive', 'Etat'),
        ];
    }

}
