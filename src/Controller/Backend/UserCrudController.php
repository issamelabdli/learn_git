<?php

namespace App\Controller\Backend; 
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
 
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

use EasyCorp\Bundle\EasyAdminBundle\Field\{
    EmailField,
    ArrayField,
    TextField,
    Field,
    BooleanField
};

class UserCrudController extends AbstractCrudController
{


    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }


    public static function getEntityFqcn(): string
    {
        return User::class;
    }

 
    public function configureFields(string $pageName): iterable
    { 
        switch ($pageName) {
            case Crud::PAGE_INDEX:

                return [
                    TextField::new('nom'),
                    TextField::new('prenom'),
                    EmailField::new('email'),
                    BooleanField::new('enabled'),
                ];
                break;
            case Crud::PAGE_DETAIL:

                return [
                    TextField::new('nom'),
                    TextField::new('prenom'),
                    EmailField::new('email'),
                    BooleanField::new('enabled'),
                ];
                break;
            
            default: 
                break;
        }
        return [ 
            TextField::new('nom'),
            TextField::new('prenom'),
            EmailField::new('email'),
            TextField::new('password')->setFormType(PasswordType::class),
            BooleanField::new('enabled'),
            ArrayField::new('roles'),
        ];
    }
  

    public function configureCrud(Crud $crud): Crud
    {
        return $crud 
            ->setPageTitle('index', 'Manage Utilisateur')  
        ;
    }

    public function createEntity(string $entityFqcn)
    {
        $user = new User();
        $user->setEnabled(false);
        return $user;
    }


    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $encodedPassword = $this->passwordEncoder->encodePassword(
            $entityInstance,
            $entityInstance->getPassword()
        );
        $entityInstance->setPassword($encodedPassword);

        $entityManager->persist($entityInstance);
        $entityManager->flush();
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $encodedPassword = $this->passwordEncoder->encodePassword(
            $entityInstance,
            $entityInstance->getPassword()
        );
        $entityInstance->setPassword($encodedPassword);

        $entityManager->persist($entityInstance);
        $entityManager->flush();
    }


}
