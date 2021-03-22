<?php

namespace App\Controller\VisualReception;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Common\CommandBus;
use App\Common\QueryBus;
use App\Repository\VisualReceptionRepository;
use App\Utils\UploaderService;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Serializer\SerializerInterface;
use App\Command\VisualReception\CreateVisualReceptionCommand;
use App\Command\VisualReception\EditVisualReceptionCommand;
use App\Command\VisualReception\DeleteVisualReceptionCommand;
use App\Query\VisualReception\RandomVisualReceptionTasksQuery;




class VisualReceptionController extends AbstractController
{
    private QueryBus $queryBus;
    private CommandBus $commandBus;
    private UploaderService $uploader;
    private SerializerInterface $serializer;
    private VisualReceptionRepository $repository;

    public function __construct(QueryBus $queryBus, CommandBus $commandBus, SerializerInterface $serializer, UploaderService  $uploader, VisualReceptionRepository $repository)
    {
        $this->queryBus = $queryBus;
        $this->commandBus = $commandBus;
        $this->serializer = $serializer;
        $this->uploader = $uploader;
        $this->repository = $repository;
    }
    /**
     * @Route("/api/v1/visual-reception/new", name="visual-reception-new")
     */
    public function createVisualReceptionAction(Request $request, ValidatorInterface $validator, TranslatorInterface $translator): JsonResponse
    {
        $data = $request->getContent();

        $data = json_decode($data, true);

        $name = $request->request->get("name");
        $file = $request->files->get("file");
        $fileName = $this->uploader->upload($file, $this->getParameter('visual_reception_directory'));
        $options = json_decode($request->request->get("options"));

        $command = new CreateVisualReceptionCommand($name, $fileName, $options);
        $this->commandBus->dispatch($command);

        return new JsonResponse([
            'status' => 'Wszystko ok'
        ], JsonResponse::HTTP_ACCEPTED);
    }

    /**
     * @Route("/api/v1/visual-reception/tasks", name="get_visual_reception_tasks")
     */
    public function getVisualReceptionTasksAction(Request $request): JsonResponse
    {
        $data = $this->queryBus->handle(new RandomVisualReceptionTasksQuery($this->getParameter('visual_reception_directory_path')));

        return new JsonResponse($this->serializer->serialize(
            $data,
            'json',
            []
        ));
    }

    /**
     * @Route("/api/v1/visual-reception/list", name="visual-reception-list")
     */
    public function getVisualReceptionTasksList(Request $request): JsonResponse
    {
        $tasks = $this->repository->getAllVisualReceptionTasks();
        return new JsonResponse($this->serializer->serialize(
            $tasks,
            'json',
            []
        ));
    }

    /**
     * @Route("/api/v1/visual-reception/task/details/{id}", name="visual-reception-task-details")
     */
    public function getVisualReceptionTaskDetails(Request $request, string $id): JsonResponse
    {
        $taskId = $id;

        $taskId = $id;

        $task = $this->repository->getTaskById($taskId, $this->getParameter('visual_reception_directory_path'));
        return new JsonResponse($this->serializer->serialize(
            $task,
            'json',
            []
        ));
    }


    /**
     * @Route("/api/v1/visual-reception/edit", name="visual-reception-edit")
     */
    public function editVisualReceptionAction(Request $request, ValidatorInterface $validator, TranslatorInterface $translator): JsonResponse
    {
        $fileName = "";
        $id = $request->request->get("id");
        $name = $request->request->get("name");
        $file = $request->files->get("file");


        if ($file) {
            $fileName = $this->uploader->upload($file, $this->getParameter('visual_reception_directory'));
        }

        $options = json_decode($request->request->get("options"));



        $command = new EditVisualReceptionCommand($id, $name, $fileName, $options);
        $this->commandBus->dispatch($command);

        return new JsonResponse([
            'status' => 'Wszystko ok'
        ], JsonResponse::HTTP_ACCEPTED);
    }

    /**
     * @Route("/api/v1/visual-reception/delete", name="visual-reception-task-delete")
     */
    public function deleteVisualReceptionAction(Request $request, ValidatorInterface $validator, TranslatorInterface $translator): JsonResponse
    {

        $id = $request->request->get('id');

        $command = new DeleteVisualReceptionCommand($id);
        $this->commandBus->dispatch($command);

        return new JsonResponse(['wszystko ok']);
    }
}
