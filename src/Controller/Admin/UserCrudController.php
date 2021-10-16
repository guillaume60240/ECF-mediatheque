<?php

namespace App\Controller\Admin;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;

class UserCrudController extends AbstractCrudController
{
    protected $entityManager;
    protected $adminUrlGenerator;

    public function __construct(EntityManagerInterface $entityManager, AdminUrlGenerator $adminUrlGenerator)
    {
        $this->entityManager = $entityManager;
        $this->adminUrlGenerator = $adminUrlGenerator;
    }

    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        $accountValidation = Action::new('accountValidation', 'Valider le compte')->linkToCrudAction('accountValidation');
        $giveRole = Action::new('giveRole', 'Assigner comme employé')->linkToCrudAction('giveRole');

        if($this->container->get('security.authorization_checker')->isGranted('ROLE_SUPER_ADMIN')){
            return $actions
            ->add('detail', $accountValidation)
            ->add('detail', $giveRole)
            ->add('index', 'detail');
        } else{
            return $actions
            ->add('detail', $accountValidation)
            ->add('index', 'detail');
        }
    }

    public function accountValidation(AdminContext $context)
    {
        $action = $context->getEntity()->getInstance();
        if($action->getAccountValidate() === false){

            $action->setAccountValidate(true);
            $action->setRoles(['ROLE_MEMBER']);
            $this->entityManager->flush();
            
            $this->addFlash('notice', "<span style='color:green;'>Le compte a été validé</span>");

        } else{
            $this->addFlash('notice', "<span style='color:red;'>Vous ne pouvez pas effectuer cette action.</span>");
        }

        return $this->redirection($action);
    }

    public function giveRole(AdminContext $context)
    {
        $action = $context->getEntity()->getInstance();

        if (in_array('ROLE_ADMIN', $action->getRoles())){
            
            $this->addFlash('notice', "<span style='color:red;'>Vous ne pouvez pas effectuer cette action.</span>");

        } else{
            $action->setRoles(['ROLE_MEMBER', 'ROLE_ADMIN']);
            $this->entityManager->flush();
            
            $this->addFlash('notice', "<span style='color:green;'>Ce membre a le rôle employé.</span>");
        }

        return $this->redirection($action);
    }

    public function redirection($action)
    {
        $url = $this->adminUrlGenerator
            ->setController(UserCrudController::class)
            ->setAction('detail')
            ->setEntityId($action->getId())
            ->generateUrl();
            
        return $this->redirect($url);
    }
    
    public function configureFields(string $pageName): iterable
    {
        return [

            TextField::new('name')
                ->setFormTypeOption('disabled','disabled'),
            TextField::new('firstname')
                ->setFormTypeOption('disabled','disabled'),
            TextField::new('email')
                ->setFormTypeOption('disabled','disabled'),
            BooleanField::new('mailValidate', 'Email validé')
                ->setFormTypeOption('disabled','disabled'),
            BooleanField::new('accountValidate', 'Compte validé')
                ->setFormTypeOption('disabled','disabled'),
            AssociationField::new('reservations', 'Nombre de réservations')
        ];
    }
    
}
