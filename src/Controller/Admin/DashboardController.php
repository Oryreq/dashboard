<?php

namespace App\Controller\Admin;

use App\Entity\Baby;
use App\Entity\Table;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;


#[IsGranted('ROLE_ADMIN')]
class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setDefaultColorScheme('dark')
            ->setTitle('Управление посадкой пупсичей');
    }

    public function configureMenuItems(): iterable
    {
        return [
            MenuItem::linkToCrud('Столы', 'fa fa-sitemap', Table::class),
            MenuItem::linkToCrud('Пупсичи', 'fa-brands fa-waze', Baby::class),
        ];
    }
}
