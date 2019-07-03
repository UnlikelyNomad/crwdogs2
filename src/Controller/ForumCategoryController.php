<?php

namespace App\Controller;

use \DateTime;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

use App\Entity\ForumCategory;
use App\Entity\ForumTopic;
use App\Entity\Role;

use App\Security\ForumCategorySecurity;

use App\Form\ForumEditCategoryType;
use App\Form\ForumEditTopicType;

/**
 * @IsGranted("ROLE_USER")
 */
class ForumCategoryController extends AbstractController
{
    /**
     * @Route("/forum/new", name="forum_new")
     */
    public function newCategory(Request $req) {
        $roleNames = $this->getDoctrine()->getRepository(Role::class)->roleNames();

        $category = new ForumCategory();

        $form = $this->createForm(ForumEditCategoryType::class, $category, [
            'role_names' => $roleNames,
        ]);

        $form->handleRequest($req);

        if ($form->isSubmitted() && $form->isValid()) {
            $category = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();

            return $this->redirectToRoute('forum_list');
        }

        return $this->render('forum/editcategory.html.twig', [
            'form' => $form->createView(),
            'error' => null,
            'label' => 'Create',
        ]);
    }

    /**
     * @Route("/forum/{id}/edit", name="forum_edit")
     */
    public function editCategory(ForumCategory $category, Request $req) {
        $roleNames = $this->getDoctrine()->getRepository(Role::class)->roleNames();

        $form = $this->createForm(ForumEditCategoryType::class, $category, [
            'role_names' => $roleNames,
        ]);

        $form->handleRequest($req);

        if ($form->isSubmitted() && $form->isValid()) {
            $category = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();

            return $this->redirectToRoute('forum_list');
        }

        return $this->render('forum/editcategory.html.twig', [
            'form' => $form->createView(),
            'error' => null,
            'label' => 'Update',
        ]);
    }

    /**
     * @Route("/forum/{id}/new", name="topic_new")
     */
    public function newTopic(ForumCategory $category, Request $req) {
        $topic = new ForumTopic();

        $form = $this->createForm(ForumEditTopicType::class, $topic);
        $perms = new ForumCategorySecurity($this->getUser(), $category);

        $form->handleRequest($req);

        if ($form->isSubmitted() && $form->isValid()) {
            $topic = $form->getData();
            $topic->setCategory($category);
            $topic->setUser($this->getUser());
            $topic->setCreated(new DateTime());
            $topic->setLastPost($topic->getCreated());

            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($topic);
            $em->flush();

            return $this->redirectToRoute('forum_topic', ['id' => $topic->getId()]);
        }

        return $this->render('forum/edittopic.html.twig', [
            'form' => $form->createView(),
            'error' => null,
            'label' => 'Create Topic',
            'category' => $category,
            'perms' => $perms,
        ]);
    }

    /**
     * @Route("/forum/{id}/{page}", name="forum_category")
     */
    public function category(ForumCategory $category, $page = 1) {
        $perms = new ForumCategorySecurity($this->getUser(), $category);

        $repo = $this->getDoctrine()->getRepository(ForumTopic::class);
        $topics = $repo->pagedTopics($category, $page, $this->getUser()->getNumDispTopics());

        //var_dump($perms);

        return $this->render('forum/category.html.twig', [
            'category' => $category,
            'topics' => $topics,
            'perms' => $perms,
        ]);
    }

    /**
     * @Route("/forum", name="forum_list")
     */
    public function index()
    {
        $catRepo = $this->getDoctrine()->getRepository(ForumCategory::class);
        $categories = $catRepo->findInSortOrder();

        $topicRepo = $this->getDoctrine()->getRepository(ForumTopic::class);
        $topics = [];

        foreach ($categories as $category) {
            $topics[] = $topicRepo->latestForCategory($category);
        }

        return $this->render('forum/list.html.twig', [
            'categories' => $categories,
            'topics' => $topics,
        ]);
    }
}
