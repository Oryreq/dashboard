<?php

namespace App\Controller\Admin;

use App\Entity\Table;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;


class TableCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Table::class;
    }


    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Стол')
            ->setEntityLabelInPlural('Столы')
            ->setPageTitle('detail', fn(Table $table) => (string)$table)
            ->setPageTitle('edit', 'Стол');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            IntegerField::new('table_number', 'Номер стола')->setRequired(true),
            TextField::new('description', 'Описание')->setRequired(false),
            IntegerField::new('getBabiesCount', 'Пупсичей')->hideWhenCreating()->hideWhenUpdating(),
            IntegerField::new('getCurrentBabiesCount', 'Присутствует пупсичей')->hideWhenCreating()->hideWhenUpdating(),
        ];
    }
}
