<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController

{
    /**
     * @Route("/user", name="user")
     */

    public function user (UserRepository $userRepository)
    {
        // je veux récupérer une instance de la variable 'UserRepository $userRepository...'
        //J'instancie dans la variable la class pour récupérer les valeurs requises

        // je crée ma route pour ma page d'utilisateur

        $users = $userRepository->findAll();
        // $types = $userRepository->findBy([],['id' =>'desc']);

        // Je crée ma recherche puis je lui donne une valeur
        return $this->render('user/user.html.twig',[
            // je crée la variable Twig 'course'  que j'irai appeler dans mon fichier Twig Home.html.twig
            'users' => $users
        ]);
    }
    /**
     * @Route("/user_insert", name="user_insert")
     */

    public function user_insert (UserRepository $userRepository,
                                   Request $request,
                                   EntityManagerInterface $entityManager)
    {
        $user = new User();
        // j'instancie un nouvel utilisateur et je lui donne la variable $user
        $userForm = $this-> createForm(UserType::class, $user);
        // je récupère le gabarit du formulaire de l'entité User,
        // créé  dans la console avec la commande make:form
        // et je le stocke dans une variable $userForm
        $userForm->handleRequest($request);
        //Je prends les données crées et les envoie à mon formulaire

        if ($userForm->isSubmitted() && $userForm->isValid()) {

            $entityManager->persist($user);
            // J'enregistre le nouvel utilisateur
            $entityManager->flush();
            //je sauvegarde la nouvelle donnée

            $this->addFlash('success', 'Votre compte utilisateur a bien été créé');
            # Je demande l'affichage du 'message' tel qu'indiqué #}
            return $this->redirectToRoute('user');
        }
        return $this->render('user/adminUserInsert.html.twig',[
            'userForm' => $userForm->createView(),
            'user' => $user]);
        }

        /**
         * @Route("/user_delete/{id}", name="user_delete")
         */

        public function userDelete(UserRepository $userRepository,
                                     EntityManagerInterface $entityManager,
                                     $id)
        {
            $user = $userRepository->find($id);
            $entityManager->remove($user);
            $entityManager->flush();
            $this->addFlash('success', 'Le compte a bien été supprimé');
            return $this->redirectToRoute('user');
        }

        /**
         * @Route("/user_update/{id}", name="user_update")
         */
    // je crée ma route pour ma page
        public function userUpdate( UserRepository $userRepository,
                                     Request $request,
                                     EntityManagerInterface $entityManager,
                                     $id)
            // Je veux récupérer une instance de la variable 'UserRepository $userRepository'
            //J'isntancie dans la variable la class pour récupérer les valeurs requises
            //Cette méthode Request permet de récupérer les données de la méthode post
        {
           $user = $userRepository->find($id);
            //j'appelle le cours dans le repository cours avec la wildcard

           $userForm = $this->createForm(UserType::class, $user);
            // je récupère le gabarit de formulaire de l'entité User,
            //  créé  dans la console avec la commande make:form.
            // et je le stocke dans une variable $userForm

           $userForm->handleRequest($request);
           //Je prends les données de ma requête et je les envois au formulaire
           if ($userForm->isSubmitted() && $userForm->isValid()) {
                $entityManager->persist($user);
               // la méthode persist indique de récupérer la variable User modifiée et d'insérer
                $entityManager->flush();
               // la méthode 'flush' enregistre la modification
               // puis j'éxécute l'URL et je vais raffraichir ma DBB

                $this->addFlash('success', 'Votre compte a bien été modifié');
                //J'ajoute un message flash pour confirmer la modif
             //   return $this->redirectToRoute('user');
               //Je crée une nouvelle route pour instancier un nouvel utilisateur
            }
           return $this->render('user/user.html.twig', [
                'courseForm' => $courseForm->createView(),
                // je retourne mon fichier twig, en lui envoyant
                // la vue du formulaire, générée avec la méthode createView()
           ]);
        }
}
