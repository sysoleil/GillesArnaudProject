<?php

namespace App\Controller;

use App\Entity\UserCourse;
use App\Form\UserCourseType;
use App\Repository\UserCourseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;

class userCourseController extends AbstractController

{
    /**
     * @Route("/user_cours", name="user_course")
     */

    public function userCourse (UserCourseRepository $userCourseRepository)
    {
        // je veux récupérer une instance de la variable 'UserCourseRepository $userCourseRepository...'
        //J'instancie dans la variable la class pour récupérer les valeurs requises

        // je crée ma route pour ma page de services

        $userCourse = $userCourseRepository->findAll();
        // $types = $userCourseRepository->findBy([],['id' =>'desc']);

        // Je crée ma recherche puis je lui donne une valeur
        return $this->render('userCourse/adminUserCourseShow.html.twig',[
            // je crée la variable Twig '$userCourse'  que j'irai appeler dans mon fichier Twig Home.html.twig
            'userCourses' => $userCourse
        ]);
    }
    /**
     * @Route("/user_cours_insert", name="user_course_insert")
     */

    public function userCourseInsert (UserCourseRepository $userCourseRepository,
                                        Request $request,
                                        EntityManagerInterface $entityManager)
    {
        $userCourse = new UserCourse();
        // j'instancie une nouvelle réservation de cours et je lui donne la variable $userCourse
        $userCourseForm = $this-> createForm(UserCourseType::class, $userCourse);
        // je crée le formulaire à qui je donne la variable $userCourseForm
        $userCourseForm->handleRequest($request);
        //Je prends les données crées et les envoie à mon formulaire

        if ($userCourseForm->isSubmitted() && $userCourseForm->isValid()) {
            // je pose deux conditions avant de traiter l'information
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($userCourse);
            // J'enregistre la nouvelle réservation de cours
            $entityManager->flush();
            //je sauvegarde la nouvelle donnée

            $this->addFlash('success', 'Votre réservation a bien été enregistrée');
            # Je demande l'affichage du 'message' tel qu'indiqué #}
            return $this->redirectToRoute('user_course');
        }
        return $this->render('userCourse/userCourseInsert.html.twig',[
            'userCourseForm' => $userCourseForm->createView(),
            'userCourse' => $userCourse]);
    }

    /**
     * @Route("/user_cours_delete/{id}", name="user_course_delete")
     */

    public function userCourseDelete(UserCourseRepository $userCourseRepository,
                                     EntityManagerInterface $entityManager,
                                     $id)
    {
        $userCourse = $userCourseRepository->find($id);
        $entityManager->remove($userCourse);
        $entityManager->flush();
        return $this->redirectToRoute('user_course');
    }

    /**
     * @Route("/user_cours_update/{id}", name="user_course_update")
     */
    // je crée ma route pour ma page
    public function userCourseUpdate(UserCourseRepository $userCourseRepository,
                                     Request $request,
                                     EntityManagerInterface $entityManager,
                                     $id)
        // Je veux récupérer une instance de la variable 'UserCourseRepository $userCourseRepository'
        //J'isntancie dans la variable la class pour récupérer les valeurs requises
        //Cette méthode Request permet de récupérer les données de la méthode post
    {
        $userCourse = $userCourseRepository->find($id);
        //j'appelle la réservation des cours dans le repository userCours avec la wildcard

        $userCourseForm = $this->createForm(UserCourseType::class, $userCourse);
        // je récupère le gabarit de formulaire de l'entité UserCourse,
        //  créé  dans la console avec la commande make:form.
        // et je le stocke dans une variable $userCourseForm

        if ($request->isMethod('POST')) {
            $userCourseForm->handleRequest($request);

            //Je prends les données de ma requête et je les envois au formulaire
            if ($userCourseForm->isSubmitted() && $userCourseForm->isValid()) {
                $entityManager->persist($userCourse);
                // la méthode persist indique de récupérer la variable userCourse modifiée
                $entityManager->flush();
                // la méthode 'flush' enregistre la modification
                // puis j'éxécute l'URL et je vais raffraichir ma DBB
                return $this->redirectToRoute('user_course');
            }
        }

        $this->addFlash('success', 'Votre réservation a bien été modifiée');
        //J'ajoute un message flash pour confirmer la modif

        $form = $userCourseForm->createView();
        //Je crée une nouvelle route pour instancier une nouvelle réservation
        return $this->render('userCourse/adminCourseInsert.html.twig', [
            'userCourseForm' => $form
            // je retourne mon fichier twig, en lui envoyant
            // la vue du formulaire, générée avec la méthode createView()
        ]);
    }
    /**
     * @Route("/admin/user_cours_show/{id}", name="admin_user_course_show")
     */

    public function adminUserCourseShow(UserCourseRepository $userCourseRepository, $id)
    {
        $userCourse = $userCourseRepository->find($id);
        return $this->render('userCourse/adminUserCourseShow.html.twig',[
            'userCourse' => $userCourse
        ]);
    }
}