<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationListInterface;
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
     * @param $payload
     * @param string $model
     * @return object
     */
    protected function validatePayload(array $payload, $model)
    {
        $data = $this->serializer->deserialize(json_encode($payload), $model, self::DEFAULT_FORMAT);
        $violations = $this->validator->validate($data);

        if (0 !== count($violations)) {

            /**
             * Faulty Response objekt hier mit daten anreichetn und als Response wiedergeben
             * - message
             * - attribute
             * - errocode
             * - 400er http code
             */

            return $this->createResponse([
                'Message' => 'Error',
                'Code' => -2
            ], Response::HTTP_BAD_REQUEST);
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
