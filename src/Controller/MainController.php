<?php

namespace App\Controller;

use App\Usecase\GetEntityRequest;
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
     * @return Response
     */
    public function getEntry(Request $request): Response
    {
        $payload = ['date' => $request->get('date')];
        $result = $this->validatePayload($payload, GetEntityRequest::class);

        if ($result instanceof Response) {
            return $result;
        }

        return $this->createResponse([
            'code' => 1,
            'message' => 'SUCCESS'
        ]);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function addEntry(Request $request): Response
    {
        return $this->createResponse([
            'code' => 1,
            'message' => 'SUCCESS'
        ]);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function changeEntry(Request $request): Response
    {
        return $this->createResponse([
            'code' => 1,
            'message' => 'SUCCESS'
        ]);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function deleteEntry(Request $request): Response
    {
        $payload = ['date' => $request->get('date')];
        $result = $this->validatePayload($payload, GetEntityRequest::class);

        return $this->createResponse([
            'code' => 1,
            'message' => 'SUCCESS'
        ]);
    }
}
