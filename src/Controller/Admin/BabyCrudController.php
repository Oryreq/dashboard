<?php

namespace App\Controller\Admin;

use App\Entity\Baby;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;


class BabyCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Baby::class;
    }


    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Пупсича')
            ->setEntityLabelInPlural('Пупсичи')
            ->setPageTitle('new', 'Создать нового пупсича')
            ->setPageTitle('detail', fn (Baby $baby) => (string) $baby)
            ->setPageTitle('edit', fn (Baby $baby) => 'Пупсича');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            BooleanField::new('is_active', 'Присутствие'),
            TextField::new('full_name', 'ФИО'),
            AssociationField::new('table_link', 'Стол')->setCrudController(TableCrudController::class),
        ];
    }
}