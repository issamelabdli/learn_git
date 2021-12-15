<?php

namespace App\Controller\Backend;

use App\Entity\Projet\Blockproject;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class BlockprojectCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Blockproject::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
