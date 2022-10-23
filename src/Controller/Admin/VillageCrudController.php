<?php

namespace App\Controller\Admin;

use App\Entity\Village;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class VillageCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Village::class;
    }


    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')
            ->hideOnForm();
        yield TextField::new('name');
        #yield TextEditorField::new('description');
        yield AssociationField::new('cards')
            ->autocomplete()
            ->setFormTypeOption('by_reference', false);
    }

}
