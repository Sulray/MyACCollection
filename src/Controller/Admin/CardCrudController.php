<?php

namespace App\Controller\Admin;

use App\Entity\Card;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CardCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Card::class;
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
        yield IdField::new('species');
        yield IdField::new('series');
        #yield TextEditorField::new('description');
        //yield AssociationField::new('village')
        //    ->autocomplete()
        //    ->setFormTypeOption('by_reference', false);
        yield AssociationField::new('personalities') // remplacer par le nom de l'attribut spécifique, par exemple 'bodyShape'
            ->onlyOnDetail()
            ->formatValue(function ($value, $entity) {
                return implode(', ', $entity->getPersonalities()->toArray()); // ici getBodyShapes()
            });

    }

}
