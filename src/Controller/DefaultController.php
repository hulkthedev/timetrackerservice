<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Alex Beirith <fatal.error.27@gmail.com>
 */
class DefaultController extends AbstractController
{
    public function __construct()
    {

    }

    protected function validatePayload()
    {

    }

    /**
     * @param mixed $content
     * @param int $status
     * @return Response
     */
    protected function createFaultyResponse($content, int $status = Response::HTTP_INTERNAL_SERVER_ERROR): Response
    {
        return $this->getResponse($content, $status);
    }

    /**
     * @param mixed $content
     * @param int $status
     * @return Response
     */
    protected function createSuccessfullyResponse($content, int $status = Response::HTTP_OK): Response
    {
        return $this->getResponse($content, $status);
    }

    /**
     * @param mixed $content
     * @param int $status
     * @return Response
     */
    private function getResponse($content, int $status): Response
    {
        return new Response(json_encode($content), $status);
    }
}
