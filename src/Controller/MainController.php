<?php

namespace App\Controller;

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
        return $this->createSuccessfullyResponse([
            'code' => 1,
            'message' => 'SUCCESS'
        ]);
    }

    /**
     * @return Response
     */
    public function getEntry(): Response
    {
        return $this->createSuccessfullyResponse([
            'code' => 1,
            'message' => 'SUCCESS'
        ]);
    }

    /**
     * @return Response
     */
    public function addEntry(): Response
    {
        return $this->createSuccessfullyResponse([
            'code' => 1,
            'message' => 'SUCCESS'
        ]);
    }

    /**
     * @return Response
     */
    public function changeEntry(): Response
    {
        return $this->createSuccessfullyResponse([
            'code' => 1,
            'message' => 'SUCCESS'
        ]);
    }

    /**
     * @return Response
     */
    public function deleteEntry(): Response
    {
        return $this->createSuccessfullyResponse([
            'code' => 1,
            'message' => 'SUCCESS'
        ]);
    }
}
