<?php

declare(strict_types=1);

namespace App\User\Api;

use App\User\Command\Delete\DeleteUserCommand;
use App\User\Command\Delete\DeleteUserCommandHandler;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route(path: '/users/{id}', methods: ['DELETE'], name: 'api_delete_user')]
#[AsController]
final readonly class DeleteUserAction
{
    public function __construct(
        private ValidatorInterface $validator,
        private SerializerInterface $serializer,
        private LoggerInterface $logger,
        private DeleteUserCommandHandler $commandHandler,
    ) {}

    public function __invoke(string $id): Response
    {
        $command = new DeleteUserCommand($id);

        $violations = $this->validator->validate($command);
        if (\count($violations)) {
            $json = $this->serializer->serialize($violations, 'json');

            return new JsonResponse($json, Response::HTTP_UNPROCESSABLE_ENTITY, [], true);
        }

        try {
            ($this->commandHandler)($command);
        } catch (\Throwable $exception) {
            $json = $this->serializer->serialize($exception->getMessage(), 'json');

            $this->logger->error($exception->getMessage());

            return new JsonResponse($json, Response::HTTP_UNPROCESSABLE_ENTITY, [], true);
        }

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}
