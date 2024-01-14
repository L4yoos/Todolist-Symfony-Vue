<?php

namespace App\Controller;

use App\Entity\Todolist;
use App\Form\TodoListType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/api', name: 'api_')]
class ApiController extends AbstractController
{
    #[Route('/', name: 'todolistIndex', methods:['get'] )]
    public function index(ManagerRegistry $doctrine): JsonResponse
    {
        $todolists = $doctrine
        ->getRepository(Todolist::class)
        ->findAll();
   
        $data = [];
   
        foreach ($todolists as $todolist) {
           $data[] = [
               'id' => $todolist->getId(),
               'title' => $todolist->getTitle(),
               'completed' => $todolist->isCompleted(),
           ];
        }
   
        return $this->json($data);
    }

    #[Route('/create', name: 'todolistCreate', methods:['post'] )]
    public function create(ManagerRegistry $doctrine, Request $request): JsonResponse
    {
        $entityManager = $doctrine->getManager();
   
        $todolist = new Todolist();

        $contentType = $request->headers->get('Content-Type');

        if ('application/json' !== $contentType) {
            return $this->json('Invalid Content-Type. Expected application/json.', 400);
        }

        $data = json_decode($request->getContent(), true);
        
        $todolist->setTitle($data['title']);
        $todolist->setCompleted(false);
   
        $entityManager->persist($todolist);
        $entityManager->flush();

        return $this->json([
            'id' => $todolist->getId(),
            'title' => $todolist->getTitle(),
            'completed' => $todolist->isCompleted()
        ]);
    }

    #[Route('/update/{id}', name: 'todolistUpdate', methods:['put', 'patch'] )]
    public function update(ManagerRegistry $doctrine, Request $request, int $id): JsonResponse
    {
        $entityManager = $doctrine->getManager();
        $todolist = $entityManager->getRepository(Todolist::class)->find($id);
   
        $contentType = $request->headers->get('Content-Type');

        if ('application/json' !== $contentType) {
            return $this->json('Invalid Content-Type. Expected application/json.', 400);
        }

        if (!$todolist) {
            return $this->json('No project found for id' . $id, 404);
        }
   
        $data = json_decode($request->getContent(), true);

        $todolist->setTitle($data['title']);
        $todolist->setCompleted($data['completed']);
        $entityManager->flush();
           
        return $this->json([
            'id' => $todolist->getId(),
            'title' => $todolist->getTitle(),
            'completed' => $todolist->isCompleted(),
        ]);
    }

    #[Route('/delete/{id}', name: 'todolistDelete', methods:['delete'] )]
    public function delete(ManagerRegistry $doctrine, int $id): JsonResponse
    {
        $entityManager = $doctrine->getManager();
        $todolist = $entityManager->getRepository(Todolist::class)->find($id);

        if (!$todolist) {
            return $this->json('No project found for id' . $id, 404);
        }

        $entityManager->remove($todolist);
        $entityManager->flush();
           
        return $this->json('Deleted a project successfully with id ' . $id);
    }
}
