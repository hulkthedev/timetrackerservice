<?php

namespace App\Controller;

use App\Usecase\FaultyResponse;
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
    protected const DEFAULT_FORMAT = 'json';

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
     * 1579626589
     *
     * @param array $payload
     * @param string $model
     * @return object
     */
    protected function validatePayload(array $payload, $model)
    {
        $data = $this->serializer->deserialize(json_encode($payload), $model, self::DEFAULT_FORMAT);
        $violations = $this->validator->validate($data);

        if ($violations->count() > 0) {
            $response = new FaultyResponse($violations);
            return $this->createResponse($response->presentResponse(), $response->getHttpStatus());
        }

        return $data;
    }

    /**
     * @param mixed $content
     * @param int $status
     * @return Response
     */
    protected function createResponse($content, int $status = Response::HTTP_OK): Response
    {
        return new Response(json_encode($content), $status);
    }
}
