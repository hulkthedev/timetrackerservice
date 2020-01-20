<?php

namespace App\Controller;

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
     * @return Response
     */
    public function getAllEntries(): Response
    {
        return $this->createResponse([
            'code' => 1,
            'message' => 'SUCCESS'
        ]);
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

//    /**
//     * @param Request $request
//     * @return Response
//     */
//    public function addEntry(Request $request): Response
//    {
//        return $this->createResponse([
//            'code' => 1,
//            'message' => 'SUCCESS'
//        ]);
//    }
//
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
//
//    /**
//     * @param Request $request
//     * @return Response
//     */
//    public function deleteEntry(Request $request): Response
//    {
//        $payload = ['date' => $request->get('date')];
//        $result = $this->validatePayload($payload, GetEntityRequest::class);
//
//        return $this->createResponse([
//            'code' => 1,
//            'message' => 'SUCCESS'
//        ]);
//    }
}
