<?php

namespace App\Controller;

use App\Entity\Idea;
use App\Form\BucketType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
class IdeaController extends AbstractController
{
    /**
     * @Route("/idea", name="idea_list")Ù
     * @IsGranted("ROLE_USER")
     */
    public function list(EntityManagerInterface $em): Response
    {
        $ideaRepos = $this->getDoctrine()->getRepository(Idea::class);
        $ideas = $ideaRepos->findListIdeaWithCategories();



        return $this->render('idea/list.html.twig', [
            'ideas' => $ideas,
        ]);
    }


    /**
     * @Route ("/idea/{id}", name="idea_detail", requirements={"id": "\d+"})
     */
    public function detail($id)
    {
        $ideaRepos = $this->getDoctrine()->getRepository(Idea::class);
        $idea = $ideaRepos->find($id);

        return $this->render('idea/detail.html.twig', [
            "idea" => $idea,
        ]);
    }
    /**
     * @Route ("/idea/add", name="idea_add")
     * @IsGranted("ROLE_USER")
     */
    public function add(EntityManagerInterface $em, Request $request):Response
    {

        $idea = new Idea();
        $form = $this->createForm(BucketType::class, $idea);

        /**
         * @todo: passer la main  a la requete pour enregister le formulaire + traitement
         */
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            // @todo: publier les idées par défaut et la date de création qui n'est pas renseignée par l'utilisateur
            $idea->setIsPublished(true);
            $idea->setDateCreated(new\ DateTime());
            $em->persist($idea);
            $em->flush();

            /**
             * @todo: Redirection vers une autre page apres soumission du formulaire
             */
            $this->addFlash('success', 'The idea has been added to the list');
            return $this->redirectToRoute('idea_detail', [
                'id'=>$idea->getId()
            ]);
        }


        return $this->render('idea/add.html.twig', [
            'form'=>$form->createView(),
        ]);
    }
}
