<?php

namespace App\Controller\Test;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Common\CommandBus;
use App\Common\QueryBus;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Command\Test\CreateTestCommand;
use App\Repository\TestRepository;


class TestController extends AbstractController
{
    private QueryBus $queryBus;
    private CommandBus $commandBus;
    private SerializerInterface $serializer;
    private TestRepository $repository;

    public function __construct(QueryBus $queryBus, CommandBus $commandBus, SerializerInterface $serializer, TestRepository $repository)
    {
        $this->queryBus = $queryBus;
        $this->commandBus = $commandBus;
        $this->serializer = $serializer;
        $this->repository = $repository;
    }
    /**
     * @Route("/api/v1/test/create", name="test-create")
     */
    public function createNewTest(Request $request, ValidatorInterface $validator, TranslatorInterface $translator): JsonResponse
    {

        $results = json_decode($request->request->get('results'));


        $command = new CreateTestCommand($results, $this->getParameter('visual_production_directory'), $this->getUser());
        $envelope = $this->commandBus->dispatch($command);

        //dump($envelope);

        //return new JsonResponse($handled->getResult());

        return new JsonResponse([
            'result' =>  $envelope->getId()
        ], JsonResponse::HTTP_ACCEPTED);
    }


    /**
     * @Route("/api/v1/test/list", name="test-list")
     */
    public function getTestsList(Request $request): JsonResponse
    {
        $tasks = $this->repository->getAllTests();
        return new JsonResponse($this->serializer->serialize(
            $tasks,
            'json',
            []
        ));
    }

    /**
     * @Route("/api/v1/test/details/{id}", name="test-details")
     */
    public function getTestDetails(Request $request, string $id): JsonResponse
    {
        $testId = $id;

        $test = $this->repository->getTestById($testId);
        return new JsonResponse($this->serializer->serialize(
            $test,
            'json',
            []
        ));
    }


    /**
     * @Route("/api/v1/test/statistics", name="tests-statistics")
     */
    public function getTestsStatistics(Request $request): JsonResponse
    {

        $statistics = $this->repository->getTestStatistics();

        return new JsonResponse($this->serializer->serialize(
            $statistics,
            'json',
            []
        ));
    }
}
