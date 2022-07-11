<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        $id = IdField::new('id');
        $image = ImageField::new('image')->setBasePath('img/products/')->setUploadDir(('public/img/products/'));
        $name = TextField::new('name');
        $price = MoneyField::new('price')->setCurrency('EUR')->setCustomOption('storedAsCents', false);
        $shortDescription = TextareaField::new('shortDescription');
        $fullDescription = TextEditorField::new('fullDescription');
        $category = AssociationField::new('category');
        $isFeatured = BooleanField::new('isFeatured');

        if (Crud::PAGE_INDEX === $pageName) {
            return [$image, $id, $name, $price, $isFeatured, $category];
        }
        else {
            return [$image, $name, $price, $shortDescription, $fullDescription, $isFeatured, $category];
        }
    }
    
}
