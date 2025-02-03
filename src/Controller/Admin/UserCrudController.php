<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle('index', 'Users')
            ->setPageTitle('new', 'New user')
            ->setPageTitle('edit', fn(User $user) => 'Editing user ' . $user->getUserIdentifier())
            ->setPageTitle('detail', fn(User $user) => $user->getUserIdentifier());
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->hideOnForm();
        yield EmailField::new('email')->setRequired(true);
        yield ChoiceField::new('roles')
            ->allowMultipleChoices()
            ->setChoices([
                'Admin' => 'ROLE_ADMIN',
                'User' => 'ROLE_USER',
            ])
            ->renderAsBadges([
                'ROLE_ADMIN' => 'success',
                'ROLE_USER' => 'primary',
            ])
            ->setRequired(true);
    }
}
