<?php

namespace App\Controller\Admin;

use App\Entity\Gallery;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class GalleryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
    return Gallery::class;
    }

    public function configureFields(string $pageName): iterable
    {

    return [
        IdField::new('id')->hideOnForm(),
        AssociationField::new('member'),
        BooleanField::new('published')
            ->onlyOnForms()
            ->hideWhenCreating(),
        TextField::new('description'),

        AssociationField::new('cards')
            ->onlyOnForms()
            // on ne souhaite pas gérer l'association entre les
            // [objets] et la [galerie] dès la crétion de la
            // [galerie]
            ->hideWhenCreating()
            ->setTemplatePath('admin/fields/village_cards.html.twig')
            // Ajout possible seulement pour des [objets] qui
            // appartiennent même propriétaire de l'[inventaire]
            // que le [createur] de la [galerie]
            ->setQueryBuilder(
                function (QueryBuilder $queryBuilder) {
                    // récupération de l'instance courante de [galerie]
                    $currentGallery = $this->getContext()->getEntity()->getInstance();
                    $member = $currentGallery->getMember();
                    $memberId = $member->getId();
                    // charge les seuls [objets] dont le 'owner' de l'[inventaire] est le [createur] de la galerie
                    $queryBuilder->leftJoin('entity.village', 'i')
                        ->leftJoin('i.member', 'm')
                        ->andWhere('m.id = :member_id')
                        ->setParameter('member_id', $memberId);
                    return $queryBuilder;
                }
            ),
    ];
    }
}
