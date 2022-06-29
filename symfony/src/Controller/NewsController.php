<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\News;


class NewsController extends AbstractController
{
    public function __construct(private ManagerRegistry $doctrine)
    {
    }

    /**
     * @Route("/news", name="news_index", methods={"GET"})
     */

    public function index(): Response
    {
        $news = $this->doctrine
            ->getRepository(News::class)
            ->findAll();

        $data = [];

        foreach ($news as $newsItem) {
            $data[] = [
                'id' => $newsItem->getId(),
                'tstmp' => $newsItem->getTstmp(),
                'title' => $newsItem->getTitle(),
                'date' => $newsItem->getDate(),
                'content' => $newsItem->getContent(),
            ];
        }
        return $this->json($data);
    }

    /**
     * @Route("/news", name="news_new", methods={"POST"})
     */
    public function new(Request $request): Response
    {
        $entityManager = $this->doctrine->getManager();

        $newsItem = new News();
        $newsItem->setTstmp();
        $newsItem->setTitle($request->request->get('title'));
        $newsItem->setDate($request->request->get('date'));
        $newsItem->setContent($request->request->get('content'));

        $entityManager->persist($newsItem);
        $entityManager->flush();

        return $this->json('Created new news successfully with id ' . $newsItem->getId());
    }

    /**
     * @Route("/news/{id}", name="news_show", methods={"GET"})
     */
    public function show(int $id): Response
    {
        $newsItem = $this->doctrine
            ->getRepository(News::class)
            ->find($id);

        if (!$newsItem) {

            return $this->json('No news found for id' . $id, 404);
        }

        $data =  [
            'tstmp' => $newsItem->getTstmp(),
            'title' => $newsItem->getTitle(),
            'date' => $newsItem->getDate(),
            'content' => $newsItem->getContent(),
        ];

        return $this->json($data);
    }

    /**
     * @Route("/news/{id}", name="news_edit", methods={"PUT"})
     */
    public function edit(Request $request, int $id): Response
    {
        $entityManager = $this->doctrine->getManager();
        $newsItem = $entityManager->getRepository(News::class)->find($id);

        if (!$newsItem) {
            return $this->json('No news found for id' . $id, 404);
        }

        $newsItem->setTstmp($request->request->get('tstmp'));
        $newsItem->setTitle($request->request->get('title'));
        $newsItem->setDate($request->request->get('date'));
        $newsItem->setContent($request->request->get('content'));
        $entityManager->flush();
        /*
        $data =  [
            'tstmp' => $newsItem->getTstmp(),
            'title' => $newsItem->getTitle(),
            'date' => $newsItem->getDate(),
            'content' => $newsItem->getContent(),
        ];
        */
        $data = [
          'tstmp' => $newsItem->getTstmp(),
          'title' => $newsItem->getDate(),
          'date' => $newsItem->getDate(),
          'content' => $request->request->get('date'),
        ];
        return $this->json($data);
    }

    /**
     * @Route("/news/{id}", name="news_delete", methods={"DELETE"})
     */
    public function delete(int $id): Response
    {
        $entityManager = $this->doctrine->getManager();
        $newsItem = $entityManager->getRepository(News::class)->find($id);

        if (!$newsItem) {
            return $this->json('No news found for id' . $id, 404);
        }

        $entityManager->remove($newsItem);
        $entityManager->flush();

        return $this->json('Deleted a news successfully with id ' . $id);
    }
}
