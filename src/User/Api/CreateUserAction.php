<?php

declare(strict_types=1);

namespace App\User\Api;

use App\User\Command\Create\CreateUserCommand;
use App\User\Command\Create\CreateUserCommandHandler;
use App\User\Service\ParameterBag;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route(path: '/users', methods: ['POST'], name: 'api_create_user')]
#[AsController]
final readonly class CreateUserAction
{
    public function __construct(
        private ValidatorInterface $validator,
        private SerializerInterface $serializer,
        private LoggerInterface $logger,
        private CreateUserCommandHandler $commandHandler,
    ) {}

    public function __invoke(Request $request): Response
    {
        $payload = ParameterBag::createFromJson($request->getContent());

        $command = new CreateUserCommand(
            $payload->getString('email'),
            $payload->getString('role'),
            $payload->getString('name'),
            $payload->getString('surname'),
            $payload->getString('password'),
        );

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
