<?php

namespace App\Controller;

use App\Usecase\AddEntity\AddEntityInteractor;
use App\Usecase\AddEntity\AddEntityRequest;
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
class MainController extends DefaultController
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
        $payload = ['date' => $request->get('date')];
        $result = $this->validatePayload($payload, GetEntityRequest::class);

        if ($result instanceof Response) {
            return $result;
        }

        $response = $interactor->execute();
        return $this->createResponse($response);
    }

    /**
     * @param Request $request
     * @param AddEntityInteractor $interactor
     * @return Response
     */
    public function addEntry(Request $request, AddEntityInteractor $interactor): Response
    {
        $payload = ['timestamp' => $request->get('timestamp')];
        $result = $this->validatePayload($payload, AddEntityRequest::class);

        if ($result instanceof Response) {
            return $result;
        }

        $response = $interactor->execute();
        return $this->createResponse($response);
    }

//    /**
//     * @param Request $request
//     * @return Response
//     */
//    public function changeEntry(Request $request): Response
//    {
//        return $this->createResponse([
//            'code' => 1,
//            'message' => 'SUCCESS'
//        ]);
//    }

    /**
     * @param Request $request
     * @param DeleteEntityInteractor $interactor
     * @return Response
     */
    public function deleteEntry(Request $request, DeleteEntityInteractor $interactor): Response
    {
        $payload = ['date' => $request->get('date')];
        $result = $this->validatePayload($payload, DeleteEntityRequest::class);

        if ($result instanceof Response) {
            return $result;
        }

        $response = $interactor->execute();
        return $this->createResponse($response);
    }
}
