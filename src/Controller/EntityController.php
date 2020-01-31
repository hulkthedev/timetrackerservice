<?php

namespace App\Controller;

use App\Usecase\AddEntity\AddEntityInteractor;
use App\Usecase\AddEntity\AddEntityRequest;
use App\Usecase\UpdateEntity\UpdateEntityInteractor;
use App\Usecase\UpdateEntity\UpdateEntityRequest;
use App\Usecase\DeleteEntity\DeleteEntityInteractor;
use App\Usecase\DeleteEntity\DeleteEntityRequest;
use App\Usecase\GetAllEntities\GetAllEntitiesInteractor;
use App\Usecase\GetEntity\GetEntityInteractor;
use App\Usecase\GetEntity\GetEntityRequest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Alex Beirith <fatal.error.27@gmail.com>
 */
class EntityController extends DefaultController
{
    /**
     * @param GetAllEntitiesInteractor $interactor
     * @return Response
     */
    public function getAllEntries(GetAllEntitiesInteractor $interactor): Response
    {
        $response = $interactor->execute();
        return $this->createResponse($response->presentResponse());
    }

    /**
     * @param Request $request
     * @param GetEntityInteractor $interactor
     * @return Response
     */
    public function getEntry(Request $request, GetEntityInteractor $interactor): Response
    {
        $result = $this->validateRequest($request, GetEntityRequest::class);
        if ($result instanceof Response) {
            return $result;
        }

        $response = $interactor->execute($result);
        return $this->createResponse($response->presentResponse(), $response->getHttpStatus());
    }

    /**
     * @param Request $request
     * @param DeleteEntityInteractor $interactor
     * @return Response
     */
    public function deleteEntry(Request $request, DeleteEntityInteractor $interactor): Response
    {
        $result = $this->validateRequest($request, DeleteEntityRequest::class);
        if ($result instanceof Response) {
            return $result;
        }

        $response = $interactor->execute($result);
        return $this->createResponse($response->presentResponse(), $response->getHttpStatus());
    }

    /**
     * @param Request $request
     * @param AddEntityInteractor $interactor
     * @return Response
     */
    public function addEntry(Request $request, AddEntityInteractor $interactor): Response
    {
        $result = $this->validateRequest($request, AddEntityRequest::class, true);
        if ($result instanceof Response) {
            return $result;
        }

        $response = $interactor->execute($result);
        return $this->createResponse($response->presentResponse(), Response::HTTP_CREATED);
    }

    /**
     * @param Request $request
     * @param UpdateEntityInteractor $interactor
     * @return Response
     */
    public function updateEntry(Request $request, UpdateEntityInteractor $interactor): Response
    {
        $result = $this->validateRequest($request, UpdateEntityRequest::class, true);
        if ($result instanceof Response) {
            return $result;
        }

        $response = $interactor->execute($result);
        return $this->createResponse($response->presentResponse(), $response->getHttpStatus());
    }
}
