<?php

declare(strict_types=1);

namespace App\Controller\Api\Smartphones;

use App\Application\Command\CreateNewSmartphoneCommand;
use App\Application\Command\RemoveSmartphoneCommand;
use App\Application\Command\Smartphone\IdCommand;
use App\Application\Command\Smartphone\SmartphoneCommand;
use App\Application\Command\Specification\CompanyCommand;
use App\Application\Command\Specification\DetailsCommand;
use App\Application\Command\Specification\IdCommand as SpecificationIdCommand;
use App\Application\Command\Smartphone\IdCommand as SmartphoneIdCommand;
use App\Application\Command\Specification\ModelCommand;
use App\Application\Command\Specification\SpecificationCommand;
use App\Application\Command\UpdateSmartphoneCommand;
use App\Application\Query\SmartphoneQuery;
use App\Controller\Api\ApiController;
use App\Controller\Api\Handlers\SmartphonesApiHandler;
use App\Entity\Smartphone\Id;
use App\Entity\Smartphones;
use League\Tactician\CommandBus;
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
    private $apiExceptionsHandler;
    private $commandBus;

    public function __construct(
        SmartphoneQuery $smartphoneQuery,
        Smartphones $smartphones,
        SmartphonesApiHandler $apiExceptionsHandler,
        CommandBus $commandBus
    ) {
        $this->smartphoneQuery = $smartphoneQuery;
        $this->smartphones = $smartphones;
        $this->apiExceptionsHandler = $apiExceptionsHandler;
        $this->commandBus = $commandBus;
    }

    /**
     * @Route("/", methods={"GET"})
     */
    public function getSmarthpones(): Response
    {
        return $this->apiExceptionsHandler->readExceptionsHandler(function () {
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
        return $this->apiExceptionsHandler->readExceptionsHandler(function () use ($id) {
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
        return $this->apiExceptionsHandler->writeExceptionsHandler(function () use ($request) {
            $this->isContentTypeEqualTo('json', $request->getContentType());

            $content = $this->getJsonContentTypeToAssocArray($request);

            if (!$content) {
                return $this->getJsonResponseWithMessage('No content passed', Response::HTTP_BAD_REQUEST);
            }

            $this->checkForRequiredParametersForPostMethod($content);

            $specification = $content['specification'];
            $details = $content['specification']['details'];

            $specificationCommand = new SpecificationCommand(
                new SpecificationIdCommand((string) Id::generate()),
                new CompanyCommand($specification['company']),
                new ModelCommand($specification['model']),
                new DetailsCommand(
                    $details['os'],
                    $details['screenSize'],
                    $details['screenResolution'],
                    $details['releasedDate']
                )
            );

            $smartphoneCommand = new SmartphoneCommand(new IdCommand($content['id']), $specificationCommand);

            $command = new CreateNewSmartphoneCommand($smartphoneCommand, $specificationCommand);
            $this->commandBus->handle($command);

            return $this->getJsonResponseWithMessage('Smartphone created', Response::HTTP_OK);
        });
    }

    /**
     * @Route("/{id}", methods={"PUT"})
     */
    public function putSmartphone(string $id, Request $request): Response
    {
        return $this->apiExceptionsHandler->writeExceptionsHandler(function () use ($id, $request) {
            $this->isContentTypeEqualTo('json', $request->getContentType());

            $content = $this->getJsonContentTypeToAssocArray($request);

            if (!$content) {
                return $this->getJsonResponseWithMessage('No content passed', Response::HTTP_BAD_REQUEST);
            }

            $this->checkForRequiredParametersForPutMethod($content);

            $specification = $content['specification'];
            $details = $content['specification']['details'];

            $specificationCommand = new SpecificationCommand(
                new SpecificationIdCommand((string) Id::generate()),
                new CompanyCommand($specification['company']),
                new ModelCommand($specification['model']),
                new DetailsCommand(
                    $details['os'],
                    $details['screenSize'],
                    $details['screenResolution'],
                    $details['releasedDate']
                )
            );

            $smartphoneCommand = new SmartphoneCommand(new IdCommand($id), $specificationCommand);

            $command = new UpdateSmartphoneCommand($smartphoneCommand, $specificationCommand);
            $this->commandBus->handle($command);

            return $this->getJsonResponseWithMessage('Smartphone resource updated', Response::HTTP_OK);
        });
    }

    /**
     * @Route("/{id}", methods={"DELETE"})
     */
    public function deleteSmartphone(string $id, Request $request): Response
    {
        return $this->apiExceptionsHandler->writeExceptionsHandler(function () use ($id, $request) {
            $command = new RemoveSmartphoneCommand(new IdCommand($id));
            $this->commandBus->handle($command);

            return $this->getJsonResponseWithMessage('Resource deleted', Response::HTTP_OK);
        });
    }

    private function checkForRequiredParametersForPutMethod(array $content): void
    {
        $this->checkForRequiredParametersInContent([
            'company',
            'model',
        ], $content['specification']);

        $this->checkForRequiredParametersInContent([
            'os',
            'screenSize',
            'screenResolution',
            'releasedDate',
        ], $content['specification']['details']);
    }

    private function checkForRequiredParametersForPostMethod(array $content): void
    {
        $this->checkForRequiredParametersInContent([
            'id',
            'specification',
        ], $content);

        $this->checkForRequiredParametersInContent([
            'company',
            'model',
        ], $content['specification']);

        $this->checkForRequiredParametersInContent([
            'os',
            'screenSize',
            'screenResolution',
            'releasedDate',
        ], $content['specification']['details']);
    }
}