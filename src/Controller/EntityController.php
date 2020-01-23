<?php

namespace App\Controller;

use App\Usecase\AddEntity\AddEntityInteractor;
use App\Usecase\AddEntity\AddEntityRequest;
use App\Usecase\ChangeEntity\ChangeEntityInteractor;
use App\Usecase\ChangeEntity\ChangeEntityRequest;
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
        return $this->createResponse($response);
    }

    /**
     * @param Request $request
     * @param GetEntityInteractor $interactor
     * @return Response
     */
    public function getEntry(Request $request, GetEntityInteractor $interactor): Response
    {
        $result = $this->validatePayload(['date' => $request->get('date')], GetEntityRequest::class);
        if ($result instanceof Response) {
            return $result;
        }

        $response = $interactor->execute($result);
        return $this->createResponse($response);
    }

    /**
     * @param Request $request
     * @param DeleteEntityInteractor $interactor
     * @return Response
     */
    public function deleteEntry(Request $request, DeleteEntityInteractor $interactor): Response
    {
        $result = $this->validatePayload(['date' => $request->get('date')], DeleteEntityRequest::class);
        if ($result instanceof Response) {
            return $result;
        }

        $response = $interactor->execute($result);
        return $this->createResponse($response);
    }

    /**
     * @todo add Location: /api/orders/ in response header
     *
     * @param Request $request
     * @param AddEntityInteractor $interactor
     * @return Response
     */
    public function addEntry(Request $request, AddEntityInteractor $interactor): Response
    {
        $result = $this->validateContentType($request->getContentType());
        if ($result instanceof Response) {
            return $result;
        }

        $result = $this->validateJsonData($request->getContent());
        if ($result instanceof Response) {
            return $result;
        }

        $payload = array_merge(
            ['date' => $request->get('date')],
            json_decode($request->getContent(), true)
        );

        $result = $this->validatePayload($payload, AddEntityRequest::class);
        if ($result instanceof Response) {
            return $result;
        }

        $response = $interactor->execute($result);
        return $this->createResponse($response, Response::HTTP_CREATED);
    }

    /**
     * @todo dont work @ symfony
     *
     * @param Request $request
     * @param ChangeEntityInteractor $interactor
     * @return Response
     */
    public function changeEntry(Request $request, ChangeEntityInteractor $interactor): Response
    {
        $result = $this->validateContentType($request->getContentType());
        if ($result instanceof Response) {
            return $result;
        }

        $result = $this->validateJsonData($request->getContent());
        if ($result instanceof Response) {
            return $result;
        }

        $payload = array_merge(
            ['date' => $request->get('date')],
            json_decode($request->getContent(), true)
        );

        $result = $this->validatePayload($payload, ChangeEntityRequest::class);
        if ($result instanceof Response) {
            return $result;
        }

        $response = $interactor->execute($result);
        return $this->createResponse($response);
    }
}
