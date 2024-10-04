<?php

declare(strict_types=1);

namespace App\User\Api;

use App\User\Query\Get\GetUserQuery;
use App\User\Query\Get\GetUserQueryHandler;
use App\User\Service\ParameterBag;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route(path: '/users/{id}', methods: ['GET'], name: 'api_get_user_information')]
#[AsController]
final readonly class GetUserAction
{
    public function __construct(
        private ValidatorInterface $validator,
        private SerializerInterface $serializer,
        private LoggerInterface $logger,
        private GetUserQueryHandler $queryHandler,
    ) {}

    public function __invoke(Request $request): Response
    {
        $attributes = new ParameterBag($request->attributes->all());

        $query = new GetUserQuery(
            $attributes->getString('id'),
        );

        $violations = $this->validator->validate($query);
        if (\count($violations)) {
            $json = $this->serializer->serialize($violations, 'json');

            return new JsonResponse($json, Response::HTTP_UNPROCESSABLE_ENTITY, [], true);
        }

        try {
            $userInformation = ($this->queryHandler)($query);
        } catch (\Throwable $exception) {
            $json = $this->serializer->serialize($exception->getMessage(), 'json');

            $this->logger->error($exception->getMessage());

            return new JsonResponse($json, Response::HTTP_UNPROCESSABLE_ENTITY, [], true);
        }

        return new JsonResponse($userInformation, Response::HTTP_OK);
    }
}
