<?php

namespace App\Controller\Auth;

use App\Command\User\ChangeEnableUserCommand;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Command\User\CreateUserCommand;
use App\Command\User\EditUserCommand;
use App\Command\User\CreateUserCommandHandler;
use App\Command\User\DeleteUserCommand;
use App\Common\CommandBus;
use App\Common\QueryBus;
use App\Query\User\UserWithEmailExistQuery;
use App\Repository\UserRepository;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Webmozart\Assert\Assert as AssertAssert;

class AuthController extends AbstractController
{
    private QueryBus $queryBus;
    private CommandBus $commandBus;
    private UserRepository $userRepository;
    private SerializerInterface $serializer;

    public function __construct(QueryBus $queryBus, CommandBus $commandBus, UserRepository $userRepository, SerializerInterface $serializer)
    {
        $this->queryBus = $queryBus;
        $this->commandBus = $commandBus;
        $this->userRepository = $userRepository;
        $this->serializer = $serializer;
    }
    /**
     * @Route("/api/v2/user/new-account", name="user-new-account")
     */
    public function createUserAccountAction(Request $request, ValidatorInterface $validator, TranslatorInterface $translator): JsonResponse
    {
        $data = $request->getContent();
        $data = json_decode($data, true);

        $email = $data['email'];
        $plainPassword = $data['plainPassword'];
        $age = $data['age'];

        $constraint = new Assert\Collection([
            'plainPassword' => [
                new Assert\Length(['max' => 200]),
                new Assert\Length(['min' => 1]),
            ],
            'age' => [
                new Assert\NotNull()
            ],
            'email' => [
                new Assert\Email(
                    [
                        'message' => $translator->trans('validator.email')
                    ]
                ),
                new Assert\NotBlank(
                    [
                        'message' => $translator->trans('validator.not_blank')
                    ]
                )
            ],
        ]);

        $errors = $validator->validate($data, $constraint);

        if (count($errors) > 0) {
            $messages = [];
            foreach ($errors as $violation) {
                $messages[$violation->getPropertyPath()] = $violation->getMessage();
            }
            return new JsonResponse([
                'error' => $messages,
            ], JsonResponse::HTTP_BAD_REQUEST);
        }

        if ($this->userWithEmailExist($email)) {
            return new JsonResponse([
                'error' => [
                    '[email]' => $translator->trans('user.create.emailExist')
                ],
            ], JsonResponse::HTTP_CONFLICT);
        }

        $command = new CreateUserCommand($email, $age, $plainPassword);
        $this->commandBus->dispatch($command);

        return new JsonResponse([
            'status' => $translator->trans('user.create.success'),
            'user_email' => $command->getEmail(),
        ], JsonResponse::HTTP_ACCEPTED);
    }

    private function userWithEmailExist(string $email): bool
    {
        return $this->queryBus->handle(new UserWithEmailExistQuery($email));
    }

    /**
     * @Route("/api/v1/users", name="users")
     */
    public function getUsersAction(Request $request): JsonResponse
    {
        $users = $this->userRepository->getAllUsers();
        return new JsonResponse($this->serializer->serialize(
            $users,
            'json',
            []
        ));
    }

    /**
     * @Route("/api/v1/user/delete", name="user-delete")
     */
    public function deleteserAccountAction(Request $request, ValidatorInterface $validator, TranslatorInterface $translator): JsonResponse
    {

        $id = $request->request->get('id');

        $command = new DeleteUserCommand($id);
        $this->commandBus->dispatch($command);

        return new JsonResponse(['wszystko ok']);
    }

    /**
     * @Route("/api/v1/user/change-enabled", name="user-change-enabled")
     */
    public function changeEnabledUserAccountAction(Request $request, ValidatorInterface $validator, TranslatorInterface $translator): JsonResponse
    {

        $id = $request->request->get('id');

        $command = new ChangeEnableUserCommand($id);
        $this->commandBus->dispatch($command);

        return new JsonResponse(['wszystko ok']);
    }


    /**
     * @Route("/api/v1/user/info", name="user-info")
     */
    public function userInformationAction(Request $request): JsonResponse
    {
        $user = $this->userRepository->getUserInforation($this->getUser());
        return new JsonResponse($this->serializer->serialize(
            $user,
            'json',
            []
        ));
    }
    /**
     * @Route("/api/v1/user/info/{id}", name="user-info-by-id")
     */
    public function userInformationByIDAction(Request $request, string $id): JsonResponse
    {
        $user = $this->userRepository->getUserInforationById($id);
        return new JsonResponse($this->serializer->serialize(
            $user,
            'json',
            []
        ));
    }

    /**
     * @Route("/api/v1/user/edit", name="user-edit")
     */
    public function editUserAction(Request $request, ValidatorInterface $validator, TranslatorInterface $translator): JsonResponse
    {

        $id = $request->request->get("id");
        $email = $request->request->get("email");
        $group = $request->request->get("group");


        $command = new EditUserCommand($id, $email, $group);
        $this->commandBus->dispatch($command);

        return new JsonResponse([
            'status' => 'Wszystko ok'
        ], JsonResponse::HTTP_ACCEPTED);
    }
}
