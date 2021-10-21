<?php

namespace App\Controller\Admin;

use App\Entity\Reservation;
use App\Repository\ReservationRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;

class ReservationCrudController extends AbstractCrudController
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
        return Reservation::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        $bookGive = Action::new('bookGive', 'Retiré')->linkToCrudAction('bookGive');
        $bookRestitution = Action::new('bookRestitution', 'Rendu')->linkToCrudAction('bookRestitution');

        return $actions
            ->add('detail', $bookGive)
            ->add('detail', $bookRestitution)
            ->add('index', 'detail')
            ->disable(Action::NEW, Action::DELETE, Action::EDIT);;
    }

    public function bookGive(AdminContext $context)
    {
        $action = $context->getEntity()->getInstance();
        if($action->getValidate() === true){
            $this->addFlash('notice', "<span style='color:red;'>Vous ne pouvez pas effectuer cette action</span>");

        return $this->redirection($action);
        }

        $date = new DateTimeImmutable();

        $action->setValidateAt($date);
        $action->setValidate(true);
        $this->entityManager->flush();

        $this->addFlash('notice', "<span style='color:green;'>Le retrait a été pris en compte</span>");

        return $this->redirection($action);
    }

    public function bookRestitution(AdminContext $context, ReservationRepository $reservationRepository)
    {
        $action = $context->getEntity()->getInstance();

        $user = $action->getUser();
        $location = $user->getLocation();
        $reservation = $reservationRepository->findOneBy(['id' => $action->getId()]);

        $action->getBook()->setAvailable(true);
        $user->setLocation($location - 1);
        $action->setRestitution(true);
        $this->entityManager->remove($reservation);
        $this->entityManager->flush();

        $this->addFlash('notice', "<span style='color:green;'>La restitution a été prise en compte</span>");

        return $this->redirection($action);
    }
    
    public function redirection($action)
    {
        $url = $this->adminUrlGenerator
            ->setController(ReservationCrudController::class)
            ->setAction('detail')
            ->setEntityId($action->getId())
            ->generateUrl();
            
        return $this->redirect($url);
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
        ->setDefaultSort(['validateAt' => 'ASC'])
        ->setDefaultSort(['validate' => 'DESC']);
    }

    public function configureFields(string $pageName): iterable
    {
        
        return [
            TextField::new('user', 'Membre')
                ->setFormTypeOption('disabled','disabled'),
            TextField::new('book', 'Livre')
                ->setFormTypeOption('disabled','disabled'),
            DateTimeField::new('createdAt', 'Réservé le')
                ->setFormTypeOption('disabled','disabled'),
            BooleanField::new('validate', 'Retiré')
                ->renderAsSwitch(false)
                ->hideOnForm(),
            DateTimeField::new('validateAt', 'Retiré le')
                ->setFormTypeOption('disabled','disabled'),
            BooleanField::new('restitution', 'Rendu')
                ->renderAsSwitch(false)
                ->hideOnForm()
        ];
    }
}
