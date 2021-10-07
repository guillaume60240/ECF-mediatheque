<?php

namespace App\Controller\Admin;

use App\Entity\Book;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class BookCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Book::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title'),
            SlugField::new('titleSlug')->setTargetFieldName('title')
                ->onlyOnDetail()
                ->onlyOnForms(),
            TextField::new('autor'),
            SlugField::new('autorSlug')->setTargetFieldName('autor')
                ->onlyOnDetail()
                ->onlyOnForms(),
            AssociationField::new('category'),
            ImageField::new('picture')
                ->setBasePath('uploads/books')
                ->setUploadDir('public/uploads/books')
                ->setUploadedFileNamePattern('[randomhash].[extension]')
                ->setRequired(false),
            DateTimeField::new('parution')
                ->onlyOnDetail()
                ->onlyOnForms(),
            TextField::new('description')
        ];
    }
    
}
