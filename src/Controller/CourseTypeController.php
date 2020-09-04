<?php

namespace App\Controller;


use App\Form\CourseType;
use App\Form\CourseTypeType;
use App\Repository\CourseTypeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CourseTypeController extends AbstractController
{
    /**
     * @Route("/cours_type", name="course_type")
     */

    public function courseType (CourseTypeRepository $courseTypeRepository)
    {
        // je veux récupérer une instance de la variable 'CourseTypeRepository $courseTypeRepository...'
        //J'instancie dans la variable la class pour récupérer les valeurs requises

        // je crée ma route pour ma page de services

        $coursesType = $courseTypeRepository->findAll();
        // $coursesTypes = $courseTypeRepository->findBy([],['id' =>'desc']);

        // Je crée ma recherche puis je lui donne une valeur
        return $this->render('courseType/adminCourseTypeShow.html.twig',[
            // je crée la variable Twig 'course'  que j'irai appeler dans mon fichier Twig Home.html.twig
            'coursesType' => $coursesType
        ]);
    }
    /**
     * @Route("/cours_type_insert", name="course_type_insert")
     */

    public function courseTypeInsert (CourseTypeRepository $courseTypeRepository,
                                   Request $request,
                                   EntityManagerInterface $entityManager)
    {
        $courseType = new CourseType();
        // j'instancie une nouvelle catégorie de cours et je lui donne la variable $courseType
        $courseTypeForm = $this-> createForm(CourseTypeType::class, $courseType);
       // $courseTypeForm = $this-> createForm(CourseType::class, $courseType);
        // je crée le formulaire à qui je donne la variable $courseTypeForm
        $courseTypeForm->handleRequest($request);
        //Je prends les données crées et les envoie à mon formulaire

        if ($courseTypeForm->isSubmitted() && $courseTypeForm->isValid()) {
            // je pose deux conditions avant de traiter l'information
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($courseType);
            // J'enregistre le nouveau cours
            $entityManager->flush();
            //je sauvegarde la nouvelle donnée

            $this->addFlash('success', 'Votre catégorie de cours a bien été créée');
            # Je demande l'affichage du 'message' tel qu'indiqué #}
            return $this->redirectToRoute('course_type');
        }
        return $this->render('courseType/adminCourseTypeInsert.html.twig',[
            'courseTypeForm' => $courseTypeForm->createView(),
            'courseType' => $courseType]);
    }

    /**
     * @Route("/course_type_delete/{id}", name="course_type_delete")
     */

    public function courseTypeDelete(CourseTypeRepository $courseTypeRepository,
                                       EntityManagerInterface $entityManager,
                                       $id)
    {
        $courseType = $courseTypeRepository->find($id);
        $entityManager->remove($courseType);
        $entityManager->flush();
        return $this->redirectToRoute('course_type');
    }

    /**
     * @Route("/cours_type_update/{id}", name="course_type_update")
     */
    // je crée ma route pour ma page
    public function courseTypeUpdate(CourseTypeRepository $courseTypeRepository,
                                    Request $request,
                                    EntityManagerInterface $entityManager,
                                    $id)
        // Je veux récupérer une instance de la variable 'CourseTypeRepository $courseTypeRepository'
        //J'isntancie dans la variable la class pour récupérer les valeurs requises
        //Cette méthode Request permet de récupérer les données de la méthode post
    {
        $courseType = $courseTypeRepository->find($id);
        //j'appelle le cours dans le repository catégorie de cours avec la wildcard

        $courseTypeForm = $this->createForm(CourseTypeType::class, $courseType);
        // je récupère le gabarit de formulaire de l'entité catégorie de Cours,
        //  créé  dans la console avec la commande make:form.
        // et je le stocke dans une variable $courseTypeForm

        if ($request->isMethod('POST')) {
            $courseTypeForm->handleRequest($request);

            //Je prends les données de ma requête et je les envois au formulaire
            if ($courseTypeForm->isSubmitted() && $courseTypeForm->isValid()) {
                $entityManager->persist($courseType);
                // la méthode persist indique de récupérer la variable courseType modifiée et d'insérer
                $entityManager->flush();
                // la méthode 'flush' enregistre la modification
                // puis j'éxécute l'URL et je vais raffraichir ma DBB
                return $this->redirectToRoute('course_type');
            }
        }

        $this->addFlash('success', 'Votre catégorie de cours a bien été modifiée');
        //J'ajoute un message flash pour confirmer la modif
        $form = $courseTypeForm->createView();
        //Je crée une nouvelle route pour instancier un nouveau cours
        return $this->render('courseType/adminCourseTypeUpdate.html.twig', [
            'courseTypeForm' => $form
            // je retourne mon fichier twig, en lui envoyant
            // la vue du formulaire, générée avec la méthode createView()
        ]);
    }
 //   /**
 //    * @Route("/cours_type_show/{id}", name="course_type_show")
  //   */

//    public function courseTypeShow(CourseTypeRepository $courseTypeRepository , $id)
//    {
//        $courseType = $courseTypeRepository->find($id);
//        return $this->render('courseType/courseTypeShow.html.twig',[
//            'courseType' => $courseType
//        ]);
 //   }
}
