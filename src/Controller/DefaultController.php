<?php

namespace App\Controller;

use App\Usecase\BaseRequest;
use App\Usecase\BaseResponse;
use App\Usecase\FaultyResponse;
use App\Usecase\ResultCodes;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Throwable;

/**
 * @author ~albei <fatal.error.27@gmail.com>
 */
class DefaultController extends AbstractController
{
    protected const SUPPORTED_FORMAT = 'json';

    private ValidatorInterface $validator;
    private SerializerInterface $serializer;

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
     * @param mixed $content
     * @param int $status
     * @param array $header
     * @return Response
     */
    protected function createResponse($content, int $status = Response::HTTP_OK, array $header = []): Response
    {
        $json = $this->serializer->serialize($content, self::SUPPORTED_FORMAT);
        return new Response($json, $status, array_merge(['Content-Type' => 'application/json'], $header));
    }

    /**
     * @param Request $request
     * @param string $model
     * @param bool $validateJson
     * @return BaseRequest|Response
     */
    protected function validateRequest(Request $request, string $model, bool $validateJson = false)
    {
        $result = $this->validateContentType($request->getContentType());
        if ($result instanceof Response) {
            return $result;
        }

        $json = [];
        if ($validateJson) {
            $requestBody = $request->getContent();
            $result = $this->validateJsonData($requestBody);
            if ($result instanceof Response) {
                return $result;
            }

            $json = json_decode($requestBody, true);
        }

        $params = [];

        if (null !== $request->get('date')) {
            $params['date'] = $request->get('date');
        }

        if (null !== $request->get('employerId')) {
            $params['employerId'] = $request->get('employerId');
        }

        if (null !== $request->get('employerWorkingTimeId')) {
            $params['employerWorkingTimeId'] = $request->get('employerWorkingTimeId');
        }

        if (null !== $request->get('toDate')) {
            $params['toDate'] = $request->get('toDate');
        }

        try {
            $result = $this->validatePayload(array_merge($params, $json), $model);
        } catch (Throwable $throwable) {
            $response = new FaultyResponse('Invalid params transmitted');
            $result = $this->createResponse($response->presentResponse(), Response::HTTP_BAD_REQUEST);
        }

        if ($result instanceof Response) {
            return $result;
        }

        return $result;
    }

    /**
     * @param array $payload
     * @param string $model
     * @return Response|BaseResponse
     */
    private function validatePayload(array $payload, $model)
    {
        /** @var BaseResponse $data */
        $data = $this->serializer->deserialize(json_encode($payload), $model, self::SUPPORTED_FORMAT);
        $violations = $this->validator->validate($data);

        if ($violations->count() > 0) {
            $response = new FaultyResponse($violations->get(0)->getMessage());
            return $this->createResponse($response->presentResponse(), Response::HTTP_BAD_REQUEST);
        }

        return $data;
    }

    /**
     * @param string|null $contentType
     * @return Response|null
     */
    private function validateContentType(?string $contentType)
    {
        if (strtolower($contentType) !== self::SUPPORTED_FORMAT) {
            $response = new FaultyResponse('Invalid content-type', ResultCodes::INVALID_MEDIA_TYPE);
            return $this->createResponse($response->presentResponse(), Response::HTTP_UNSUPPORTED_MEDIA_TYPE);
        }

        return null;
    }

    /**
     * @param string|null $json
     * @return Response|null
     */
    private function validateJsonData(?string $json)
    {
        if (null === $json || null === json_decode($json)) {
            $response = new FaultyResponse('Invalid json', ResultCodes::INVALID_JSON_CONTENT);
            return $this->createResponse($response->presentResponse(), Response::HTTP_BAD_REQUEST);
        }

        return null;
    }
}
