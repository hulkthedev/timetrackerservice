<?php

namespace App\Controller;

use App\Usecase\EntityRequestInterface;
use App\Usecase\FaultyResponse;
use App\Usecase\ResultCodes;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @author Alex Beirith <fatal.error.27@gmail.com>
 */
class DefaultController extends AbstractController
{
    protected const SUPPORTED_FORMAT = 'json';

    /** @var ValidatorInterface */
    private $validator;

    /** @var SerializerInterface  */
    private $serializer;

    public function __construct()
    {
        $serializer = new Serializer([new ObjectNormalizer(), new DateTimeNormalizer()], [new JsonEncoder()]);
        $validator = Validation::createValidatorBuilder()
            ->addYamlMapping($_SERVER['DOCUMENT_ROOT'] . '/../config/validator/validation.yaml')
            ->getValidator();

        $this->validator = $validator;
        $this->serializer =  $serializer;
    }

    /**
     * @param array $payload
     * @param string $model
     * @return Response|EntityRequestInterface
     */
    protected function validatePayload(array $payload, $model)
    {
        $data = $this->serializer->deserialize(json_encode($payload), $model, self::SUPPORTED_FORMAT);
        $violations = $this->validator->validate($data);

        if ($violations->count() > 0) {
            $response = new FaultyResponse('Syntax error on attribute ' . $violations->get(0)->getPropertyPath());
            return $this->createResponse($response->presentResponse(), Response::HTTP_BAD_REQUEST);
        }

        return $data;
    }

    /**
     * @param string|null $contentType
     * @return Response|null
     */
    protected function validateContentType(?string $contentType)
    {
        if (strtolower($contentType) !== self::SUPPORTED_FORMAT) {
            $response = new FaultyResponse('Unsupported content-type', ResultCodes::CODE_UNSUPPORTED_MEDIA_TYPE);
            return $this->createResponse($response->presentResponse(), Response::HTTP_UNSUPPORTED_MEDIA_TYPE);
        }

        return null;
    }

    /**
     * @param mixed $content
     * @param int $status
     * @return Response
     */
    protected function createResponse($content, int $status = Response::HTTP_OK): Response
    {
        return new Response(json_encode($content), $status, ['Content-Type' => 'application/json']);
    }
}
