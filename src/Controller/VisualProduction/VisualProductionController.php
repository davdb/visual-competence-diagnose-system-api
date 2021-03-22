<?php

namespace App\Controller\VisualProduction;

use App\Command\VisualProduction\CreateVisualProductionCommand;
use App\Command\VisualProduction\EditVisualProductionCommand;
use App\Command\VisualProduction\DeleteVisualProductionCommand;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Common\CommandBus;
use App\Common\QueryBus;
use App\Query\VisualProduction\RandomVisualProductionTasksQuery;
use App\Repository\VisualProductionRepository;
use App\Utils\UploaderService;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Serializer\SerializerInterface;




class VisualProductionController extends AbstractController
{
    private QueryBus $queryBus;
    private CommandBus $commandBus;
    private UploaderService $uploader;
    private SerializerInterface $serializer;
    private VisualProductionRepository $repository;

    public function __construct(QueryBus $queryBus, CommandBus $commandBus, SerializerInterface $serializer, UploaderService  $uploader, VisualProductionRepository $repository)
    {
        $this->queryBus = $queryBus;
        $this->commandBus = $commandBus;
        $this->serializer = $serializer;
        $this->uploader = $uploader;
        $this->repository = $repository;
    }
    /**
     * @Route("/api/v1/visual-production/new", name="visual-production-new")
     */
    public function createVisualProductionAction(Request $request, ValidatorInterface $validator, TranslatorInterface $translator): JsonResponse
    {

        $name = $request->request->get("name");
        $shapes = json_decode($request->request->get("shapes"));
        $colors = json_decode($request->request->get("colors"));

        $command = new CreateVisualProductionCommand($name, $shapes, $colors);
        $this->commandBus->dispatch($command);

        return new JsonResponse([
            'status' => 'Wszystko ok'
        ], JsonResponse::HTTP_ACCEPTED);
    }


    /**
     * @Route("/api/v1/visual-production/edit", name="visual-production-edit")
     */
    public function editVisualProductionAction(Request $request, ValidatorInterface $validator, TranslatorInterface $translator): JsonResponse
    {

        $id = $request->request->get("id");
        $name = $request->request->get("name");
        $shapes = json_decode($request->request->get("shapes"));
        $colors = json_decode($request->request->get("colors"));

        $command = new EditVisualProductionCommand($id, $name, $shapes, $colors);
        $this->commandBus->dispatch($command);

        return new JsonResponse([
            'status' => 'Wszystko ok'
        ], JsonResponse::HTTP_ACCEPTED);
    }

    /**
     * @Route("/api/v1/visual-production/list", name="visual-production-list")
     */
    public function getVisualProductionTasksList(Request $request): JsonResponse
    {
        $tasks = $this->repository->getAllVisualProductionTasks();
        return new JsonResponse($this->serializer->serialize(
            $tasks,
            'json',
            []
        ));
    }

    /**
     * @Route("/api/v1/visual-production/tasks", name="get_visual_producetion_tasks")
     */
    public function getVisualProductionTasksAction(Request $request): JsonResponse
    {
        $data = $this->queryBus->handle(new RandomVisualProductionTasksQuery());

        return new JsonResponse($this->serializer->serialize(
            $data,
            'json',
            []
        ));
    }

    /**
     * @Route("/api/v1/visual-production/task/details/{id}", name="visual-production-task-details")
     */
    public function getVisualProductionTaskDetails(Request $request, string $id): JsonResponse
    {
        $taskId = $id;

        $task = $this->repository->getTaskById($taskId);
        return new JsonResponse($this->serializer->serialize(
            $task,
            'json',
            []
        ));
    }

    /**
     * @Route("/api/v1/visual-production/delete", name="visual-production-task-delete")
     */
    public function deleteVisualProductionAction(Request $request, ValidatorInterface $validator, TranslatorInterface $translator): JsonResponse
    {

        $id = $request->request->get('id');

        $command = new DeleteVisualProductionCommand($id);
        $this->commandBus->dispatch($command);

        return new JsonResponse(['wszystko ok']);
    }
}
