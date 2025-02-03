<?php

namespace App\Controller\Admin;

use App\Entity\Service;
use App\Entity\ServiceRequest;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted("ROLE_ADMIN")]
#[AdminDashboard(routePath: '/admin', routeName: 'admin')]
class DashboardController extends AbstractDashboardController
{
    public function index(): Response
    {
        return $this->redirectToRoute('admin_service_request_index');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Service Requests');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToCrud('Service requests', 'fas fa-list', ServiceRequest::class);
        yield MenuItem::linkToCrud('Services', 'fas fa-pen-fancy', Service::class);
        yield MenuItem::linkToCrud('Users', 'fas fa-user', User::class);
    }
}
