<?php

namespace App\Controller;

use App\Api\Reader\UserReaderInterface;
use App\Api\Writer\UserWriterInterface;
use Exception;
use Shared\ApiGeneralBundle\Exception\Resource\ResourceExceptionInterface;
use Shared\UserDto\Dto\User;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Throwable;

class ApiController
{
    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @var UserReaderInterface
     */
    private $userReader;

    /**
     * @var UserWriterInterface
     */
    private $userWriter;

    /**
     * @param SerializerInterface $serializer
     * @param UserReaderInterface $userReader
     * @param UserWriterInterface $userWriter
     */
    public function __construct(
        SerializerInterface $serializer,
        UserReaderInterface $userReader,
        UserWriterInterface $userWriter
    ) {
        $this->serializer = $serializer;
        $this->userReader = $userReader;
        $this->userWriter = $userWriter;
    }

    /**
     * @Route("/api/user", methods={"POST"})
     *
     * @param Request $request
     *
     * @return Response
     */
    public function createUser(Request $request): JsonResponse
    {
        /**
         * @var User $user
         */
        $user = $this->serializer->deserialize((string)$request->getContent(), User::class, 'json');

        try {
            $user = $this->userWriter->create($user);
        } catch (ResourceExceptionInterface $resourceException) {
            return $this->buildErrorResponse($resourceException, $resourceException->getHttpResponseCode());
        } catch (Throwable $genericException) {
            return $this->buildErrorResponse($genericException, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->buildResponse($user, Response::HTTP_CREATED);
    }

    /**
     * @Route("/api/user", methods={"GET"})
     *
     * @param Request $request
     *
     * @return Response
     */
    public function findUser(Request $request): JsonResponse
    {
        $email = $request->query->get('email');
        $password = $request->query->get('password');

        try {
            $user = $this->userReader->findBy($email, $password);
        } catch (ResourceExceptionInterface $resourceException) {
            return $this->buildErrorResponse($resourceException, $resourceException->getHttpResponseCode());
        } catch (Throwable $genericException) {
            return $this->buildErrorResponse($genericException, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->buildResponse($user, Response::HTTP_OK);
    }

    /**
     * @param Exception $exception
     * @param int $responseCode
     *
     * @return JsonResponse
     */
    private function buildErrorResponse(Exception $exception, int $responseCode): JsonResponse
    {
        return new JsonResponse($this->serializer->serialize($exception, 'json'), $responseCode, [], true);
    }

    /**
     * @param object $object
     * @param int $responseCode
     *
     * @return JsonResponse
     */
    private function buildResponse(object $object, int $responseCode): JsonResponse
    {
        return new JsonResponse($this->serializer->serialize($object, 'json'), $responseCode, [], true);
    }
}
