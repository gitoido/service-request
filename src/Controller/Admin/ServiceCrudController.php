<?php

namespace App\Controller\Admin;

use App\Entity\Service;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ServiceCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Service::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle('index', 'Services')
            ->setPageTitle('new', 'New service')
            ->setPageTitle('edit', fn(Service $service) => 'Editing ' . $service->getName())
            ->setPageTitle('detail', fn(Service $service) => $service->getName())
            ;
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id');
        yield TextField::new('name')
            ->setRequired(true);
        yield MoneyField::new('price')
            ->setRequired(true)
            ->setCurrency('USD')
            ->setStoredAsCents();
    }
}
