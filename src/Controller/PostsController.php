<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\User;
use App\Form\PostType;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PostsController extends Controller
{

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function createAction(Request $request)
    {
        /** @var User $user */
        $user = $this->getUser();
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $newPost = new Post();
        $newPost->setCreator($user);

        $form = $this->createForm(PostType::class, $newPost, ['method' => 'POST']);
        if ('POST' == $request->getMethod()) {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $em->persist($newPost);
                $em->flush();
                return $this->redirectToRoute('app_index_main');
            }
        }

        return $this->render('post/create.html.twig',
            [
                'form' => $form->createView(),
                'header' => 'Create Post',
                'creator' => $user->getEmail()
            ]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Exception
     */
    public function editAction(Request $request, $id)
    {
        /** @var User $user */
        $user = $this->getUser();
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();


        $userPost = $em->getRepository('App\Entity\Post')->findOneBy(['id' => $id, 'creator' => $user]);
        if (!$userPost) {
            throw new \Exception('Logic error');
        }

        $form = $this->createForm(PostType::class, $userPost, ['method' => 'PUT']);

        if ('PUT' == $request->getMethod()) {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $em->flush();
                return $this->redirectToRoute('app_index_main');
            }
        }


        return $this->render('post/create.html.twig',
            [
                'form' => $form->createView(),
                'header' => 'Edit Post',
                'creator' => $user->getEmail()
            ]);
    }
}