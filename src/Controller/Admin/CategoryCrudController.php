<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CategoryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Category::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud->setPageTitle('index', 'Catégories');
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name', 'Nom'),
            SlugField::new('nameCrud')->setTargetFieldName('name')
                ->onlyOnDetail()
                ->onlyOnForms(),
            TextField::new('subCategory', 'Sous catégorie'),
            SlugField::new('subCategoryCrud')->setTargetFieldName('subCategory')
                ->onlyOnDetail()
                ->onlyOnForms()
        ];
    }
    
}
