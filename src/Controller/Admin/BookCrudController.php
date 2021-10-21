<?php

namespace App\Controller\Admin;

use App\Entity\Book;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class BookCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Book::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud->setPageTitle('index', 'Livres');
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title', 'Titre'),
            SlugField::new('titleSlug')->setTargetFieldName('title')
                ->onlyOnDetail()
                ->onlyOnForms(),
            TextField::new('author', 'Auteur'),
            SlugField::new('authorSlug')->setTargetFieldName('author')
                ->onlyOnDetail()
                ->onlyOnForms(),
            AssociationField::new('category', 'Categorie'),
            ImageField::new('picture', 'Image')
                ->setBasePath('uploads/books')
                ->setUploadDir('public/uploads/books')
                ->setUploadedFileNamePattern('[randomhash].[extension]')
                ->setRequired(false)
                ->onlyOnDetail()
                ->onlyOnForms(),
            NumberField::new('parution')
                ->onlyOnDetail()
                ->onlyOnForms(),
            TextField::new('description', 'Résumé')
                ->onlyOnDetail()
                ->onlyOnForms(),
            BooleanField::new('available', 'Disponible')->setValue(true)
        ];
    }
    
}
