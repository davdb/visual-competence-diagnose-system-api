<?php

namespace App\Controller\VisualPerception;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Command\VisualPerception\CreateVisualPerceptionCommand;
use App\Command\VisualPerception\EditVisualPerceptionCommand;
use App\Command\VisualPerception\DeleteVisualPerceptionCommand;
use App\Command\VisualPerception\CreateVisualPerceptionCommandHandler;
use App\Common\CommandBus;
use App\Common\QueryBus;
use App\Entity\VisualPerception;
use App\Query\VisualPerception\RandomVisualPerceptionTasksQuery;
use App\Repository\VisualPerceptionRepository;
use App\Utils\UploaderService;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Serializer\SerializerInterface;




class VisualPerceptionController extends AbstractController
{
    private QueryBus $queryBus;
    private CommandBus $commandBus;
    private UploaderService $uploader;
    private SerializerInterface $serializer;
    private VisualPerceptionRepository $repository;

    public function __construct(QueryBus $queryBus, CommandBus $commandBus, SerializerInterface $serializer, UploaderService  $uploader, VisualPerceptionRepository $repository)
    {
        $this->queryBus = $queryBus;
        $this->commandBus = $commandBus;
        $this->serializer = $serializer;
        $this->uploader = $uploader;
        $this->repository = $repository;
    }
    /**
     * @Route("/api/v2/visual-perception/new", name="visual-perception-new")
     */
    public function createVisualPerceptionAction(Request $request, ValidatorInterface $validator, TranslatorInterface $translator): JsonResponse
    {
        $data = $request->getContent();

        $data = json_decode($data, true);
        $name = $request->request->get("name");
        $file = $request->files->get("file");
        $fileName = $this->uploader->upload($file, $this->getParameter('visual_perception_directory'));
        $options = json_decode($request->request->get("options"));

        $command = new CreateVisualPerceptionCommand($name, $fileName, $options);
        $this->commandBus->dispatch($command);

        return new JsonResponse([
            'status' => 'Wszystko ok'
        ], JsonResponse::HTTP_ACCEPTED);
    }
    /**
     * @Route("/api/v1/visual-perception/edit", name="visual-perception-edit")
     */
    public function editVisualPerceptionAction(Request $request, ValidatorInterface $validator, TranslatorInterface $translator): JsonResponse
    {
        $fileName = "";
        $id = $request->request->get("id");
        $name = $request->request->get("name");
        $file = $request->files->get("file");


        if ($file) {
            $fileName = $this->uploader->upload($file, $this->getParameter('visual_perception_directory'));
        }

        $options = json_decode($request->request->get("options"));



        $command = new EditVisualPerceptionCommand($id, $name, $fileName, $options);
        $this->commandBus->dispatch($command);

        return new JsonResponse([
            'status' => 'Wszystko ok'
        ], JsonResponse::HTTP_ACCEPTED);
    }

    /**
     * @Route("/api/v1/visual-perception/tasks", name="get_visual_perception_tasks")
     */
    public function getVisualPerceptionTasksAction(Request $request): JsonResponse
    {
        $data = $this->queryBus->handle(new RandomVisualPerceptionTasksQuery($this->getParameter('visual_perception_directory_path')));

        return new JsonResponse($this->serializer->serialize(
            $data,
            'json',
            []
        ));
    }

    /**
     * @Route("/api/v1/visual-perception/list", name="visual-perception-list")
     */
    public function getVisualPerceptionTasksList(Request $request): JsonResponse
    {
        $tasks = $this->repository->getAllVisualPerceptionTasks();
        return new JsonResponse($this->serializer->serialize(
            $tasks,
            'json',
            []
        ));
    }

    /**
     * @Route("/api/v1/visual-perception/task/details/{id}", name="visual-perception-task-details")
     */
    public function getVisualPerceptionTaskDetails(Request $request, string $id): JsonResponse
    {
        $taskId = $id;

        $task = $this->repository->getTaskById($taskId, $this->getParameter('visual_perception_directory_path'));
        return new JsonResponse($this->serializer->serialize(
            $task,
            'json',
            []
        ));
    }

    /**
     * @Route("/api/v1/visual-perception/delete", name="visual-perception-task-delete")
     */
    public function deleteVisualPerceptionAction(Request $request, ValidatorInterface $validator, TranslatorInterface $translator): JsonResponse
    {

        $id = $request->request->get('id');

        $command = new DeleteVisualPerceptionCommand($id);
        $this->commandBus->dispatch($command);

        return new JsonResponse(['wszystko ok']);
    }
}
