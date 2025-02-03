<?php

namespace App\Controller\Admin;

use App\Entity\ServiceRequest;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;

class ServiceRequestCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ServiceRequest::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle('index', 'Service requests')
            ->setPageTitle('new', 'New service request')
            ->setPageTitle('edit', fn(ServiceRequest $request) => 'Editing Request #' . $request->getId())
            ->setPageTitle('detail', fn(ServiceRequest $request) => 'Request #' . $request->getId());
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            AssociationField::new('service'),
            AssociationField::new('user'),
        ];
    }
}
