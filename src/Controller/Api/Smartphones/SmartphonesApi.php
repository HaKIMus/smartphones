<?php

declare(strict_types=1);

namespace App\Controller\Api\Smartphones;

use App\Application\Command\CreateNewSmartphoneCommand;
use App\Application\Command\UpdateSmartphoneCommand;
use App\Application\Handler\CreateNewSmartphoneHandler;
use App\Application\Handler\UpdateSmartphoneHandler;
use App\Controller\Api\ApiController;
use App\Infrastructure\Doctrine\Dbal\Repository\Smartphone\ReadSmartphoneRepository;
use App\Infrastructure\Doctrine\Dbal\Repository\Smartphone\WriteSmartphoneRepository;
use App\Entity\Smartphone\Id;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/v1/smartphones")
 */
final class SmartphonesApi extends ApiController
{
    private $readSmartphoneRepository;
    private $writeSmartphoneRepository;

    public function __construct(
        ReadSmartphoneRepository $readSmartphoneRepository,
        WriteSmartphoneRepository $writeSmartphoneRepository
    ) {
        $this->readSmartphoneRepository = $readSmartphoneRepository;
        $this->writeSmartphoneRepository = $writeSmartphoneRepository;
    }

    /**
     * @Route("/", methods={"GET"})
     */
    public function getSmarthpones(): Response
    {
        try {
            $smartphones = $this->readSmartphoneRepository->findAll();

            if (!$smartphones) {
                return new JsonResponse($smartphones, JsonResponse::HTTP_NOT_FOUND);
            }

            return new JsonResponse($smartphones, JsonResponse::HTTP_OK);
        } catch (\Exception $e) {
            return $this->internalServerErrorResponse();
        }
    }

    /**
     * To post new Smartphone you have to send the
     * * string $id,
     * * array $specification
     * * string $releaseDate
     * data in json format.
     *
     * @Route("/", methods={"POST"})
     *
     * @return Response
     */
    public function postSmartphones(Request $request): Response
    {
        try {
            $this->isContentTypeEqualTo('json', $request->getContentType());

            try {
                $content = json_decode($request->getContent(), true);

                if (!$content) {
                    return new Response('No required content', Response::HTTP_BAD_REQUEST);
                }

                $id = (string) $content['id'] ?? '';
                $specification = (array) $content['specification'] ?? [];
                $releaseDate = (string) $content['releaseDate'] ?? '';

                $command = new CreateNewSmartphoneCommand($id, $specification, $releaseDate);
            } catch (\Exception $exception) {
                return new Response('Some data missed', Response::HTTP_BAD_REQUEST);
            }

            try {
                $handler = new CreateNewSmartphoneHandler($this->writeSmartphoneRepository);
                $handler->handle($command);
            } catch (\Exception $exception) {
                return new Response('Given data are not valid', Response::HTTP_BAD_REQUEST);
            }

            return new Response('New smartphone created', Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->internalServerErrorResponse();
        }
    }

    /**
     * @Route("/{id}", methods={"GET"})
     */
    public function getSmartphone(string $id): Response
    {
        try {
            $smartphone = $this->readSmartphoneRepository->findById(Id::fromString($id));

            if (!$smartphone) {
                return new JsonResponse($smartphone, JsonResponse::HTTP_NOT_FOUND);
            }

            return new JsonResponse($smartphone, JsonResponse::HTTP_OK);
        } catch (\Exception $e) {
            return $this->internalServerErrorResponse();
        }
    }

    /**
     * @Route("/{id}", methods={"PUT"})
     */
    public function putSmartphone(string $id, Request $request): Response
    {
        try {
            $this->isContentTypeEqualTo('json', $request->getContentType());

            try {
                $content = json_decode($request->getContent(), true);

                if (!$content) {
                    return new JsonResponse(['message' => 'No content passed.', 'statusCode' => Response::HTTP_BAD_REQUEST], Response::HTTP_BAD_REQUEST);
                }

                $specification = (array) $content['specification'] ?? [];
                $releaseDate = (string) $content['releaseDate'] ?? '';

                $command = new UpdateSmartphoneCommand($id, $specification, $releaseDate);
            } catch (\Exception $e) {
                return new JsonResponse(['message' => 'No required content', 'statusCode' => Response::HTTP_BAD_REQUEST], Response::HTTP_BAD_REQUEST);
            }

            try {
                $handler = new UpdateSmartphoneHandler($this->writeSmartphoneRepository);
                $handler->handle($command);
            } catch (\Exception $e) {
                return new JsonResponse(['message' => 'Given data are not valid', 'statusCode' => Response::HTTP_BAD_REQUEST], Response::HTTP_BAD_REQUEST);
            }

            return new JsonResponse(['message' => 'Smartphone resource updated', 'statusCode' => Response::HTTP_OK], JsonResponse::HTTP_OK);
        } catch (\Exception $e) {
            return $this->internalServerErrorResponse();
        }
    }

    /**
     * @Route("/", methods={"PATCH"})
     */
    public function patchSmartphone(Request $request): Response
    {
        try {
            $this->isContentTypeEqualTo('json', $request->getContentType());

            try {
                $content = json_decode($request->getContent(), true);

                if (!$content) {
                    return new JsonResponse(['message' => 'Wrong content type', 'statusCode' => Response::HTTP_BAD_REQUEST], Response::HTTP_BAD_REQUEST);
                }

                $id = (string) $content['id'] ?? '';
                $specification = (array) $content['specification'] ?? [];
                $releaseDate = (string) $content['releaseDate'] ?? '';

                $command = new UpdateSmartphoneCommand($id, $specification, $releaseDate);
            } catch (\Exception $e) {
                return new JsonResponse(['message' => 'No required content', 'statusCode' => Response::HTTP_BAD_REQUEST], Response::HTTP_BAD_REQUEST);
            }

            try {
                $handler = new UpdateSmartphoneHandler($this->writeSmartphoneRepository);
                $handler->handle($command);
            } catch (\Exception $e) {
                return new JsonResponse(['message' => 'Given data are not valid', 'statusCode' => Response::HTTP_BAD_REQUEST], Response::HTTP_BAD_REQUEST);
            }

            return new JsonResponse(['message' => 'Smartphone resource updated', 'statusCode' => Response::HTTP_OK], JsonResponse::HTTP_OK);
        } catch (\Exception $e) {
            return $this->internalServerErrorResponse();
        }
    }

    /**
     * @Route("/{id}", methods={"DELETE"})
     */
    public function deleteSmartphone(string $id, Request $request): Response
    {
        try {
            try {
                $smartphone = $this->writeSmartphoneRepository->findById(Id::fromString($id));
            } catch (\Exception $exception) {
                return new JsonResponse([], JsonResponse::HTTP_NOT_FOUND);
            }

            if (!$smartphone) {
                return new JsonResponse([], JsonResponse::HTTP_NOT_FOUND);
            }

            $this->writeSmartphoneRepository->remove($smartphone);

            return new JsonResponse('Resource deleted successfully', JsonResponse::HTTP_OK);
        } catch (\Exception $e) {
            return $this->internalServerErrorResponse();
        }
    }
}