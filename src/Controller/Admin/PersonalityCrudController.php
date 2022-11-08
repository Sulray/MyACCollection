<?php

namespace App\Controller\Admin;

use App\Entity\Personality;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class PersonalityCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Personality::class;
    }

    public function configureActions(Actions $actions): Actions
    {

        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ;
    }


    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')
            ->hideOnForm();
        yield TextField::new('name');
        yield TextField::new('parent');

        #yield TextEditorField::new('description');
        yield AssociationField::new('cards')
            ->autocomplete()
            ->setFormTypeOption('by_reference', false)
            ->setTemplatePath('admin/fields/personality_cards.html.twig');
    }

}
