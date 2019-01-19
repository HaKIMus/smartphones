<?php

declare(strict_types=1);

namespace App\Controller\Api\Smartphones;

use App\Application\Command\CreateNewSmartphoneCommand;
use App\Application\Command\RemoveSmartphoneCommand;
use App\Application\Command\UpdateSmartphoneCommand;
use App\Application\Handler\CreateNewSmartphoneHandler;
use App\Application\Handler\RemoveSmartphoneHandler;
use App\Application\Handler\UpdateSmartphoneHandler;
use App\Application\Query\SmartphoneQuery;
use App\Controller\Api\ApiController;
use App\Controller\Api\Handlers\SmartphonesApiHandler;
use App\Entity\Smartphone\Id;
use App\Entity\Smartphones;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/v1/smartphones")
 */
final class SmartphonesApi extends ApiController
{
    private $smartphoneQuery;
    private $smartphones;

    public function __construct(
        SmartphoneQuery $smartphoneQuery,
        Smartphones $smartphones
    ) {
        $this->smartphoneQuery = $smartphoneQuery;
        $this->smartphones = $smartphones;
    }

    /**
     * @Route("/", methods={"GET"})
     */
    public function getSmarthpones(): Response
    {
        return SmartphonesApiHandler::readExceptionsHandler(function () {
            $smartphones = $this->smartphoneQuery->findAll();

            if (!$smartphones) {
                return $this->getJsonResponseWithMessage('No resource found', Response::HTTP_NOT_FOUND);
            }

            return new JsonResponse($smartphones, JsonResponse::HTTP_OK);
        });
    }

    /**
     * @Route("/{id}", methods={"GET"})
     */
    public function getSmartphone(string $id): Response
    {
        return SmartphonesApiHandler::readExceptionsHandler(function () use ($id) {
            $smartphone = $this->smartphoneQuery->findById(Id::fromString($id));

            if (!$smartphone) {
                return $this->getJsonResponseWithMessage('No resource found with such id', Response::HTTP_NOT_FOUND);
            }

            return new JsonResponse($smartphone, JsonResponse::HTTP_OK);
        });
    }

    /**
     * @Route("/", methods={"POST"})
     */
    public function postSmartphones(Request $request): Response
    {
        return SmartphonesApiHandler::writeExceptionsHandler(function () use ($request) {
            $this->isContentTypeEqualTo('json', $request->getContentType());

            $content = $this->getJsonContentTypeToAssocArray($request);

            if (!$content) {
                return $this->getJsonResponseWithMessage('No content passed', Response::HTTP_BAD_REQUEST);
            }

            $this->checkForRequiredParametersInContent(['id', 'specification', 'releaseDate'], $content);

            $command = new CreateNewSmartphoneCommand($content['id'], $content['specification'], $content['releaseDate']);
            $handler = new CreateNewSmartphoneHandler($this->smartphones);
            $handler->handle($command);

            return $this->getJsonResponseWithMessage('Smartphone created', Response::HTTP_OK);
        });
    }

    /**
     * @Route("/{id}", methods={"PUT"})
     */
    public function putSmartphone(string $id, Request $request): Response
    {
        return SmartphonesApiHandler::writeExceptionsHandler(function () use ($id, $request) {
            $this->isContentTypeEqualTo('json', $request->getContentType());

            $content = $this->getJsonContentTypeToAssocArray($request);

            if (!$content) {
                return $this->getJsonResponseWithMessage('No content passed', Response::HTTP_BAD_REQUEST);
            }

            $this->checkForRequiredParametersInContent(['specification', 'releaseDate'], $content);

            $command = new UpdateSmartphoneCommand($id,  $content['specification'], $content['releaseDate']);
            $handler = new UpdateSmartphoneHandler($this->smartphones);
            $handler->handle($command);

            return $this->getJsonResponseWithMessage('Smartphone resource updated', Response::HTTP_OK);
        });
    }

    /**
     * @Route("/{id}", methods={"DELETE"})
     */
    public function deleteSmartphone(string $id, Request $request): Response
    {
        return SmartphonesApiHandler::writeExceptionsHandler(function () use ($id, $request) {
            $command = new RemoveSmartphoneCommand($id);
            $handler = new RemoveSmartphoneHandler($this->smartphones);

            $handler->handle($command);

            return $this->getJsonResponseWithMessage('Resource deleted', Response::HTTP_OK);
        });
    }
}