<?php

namespace App\Tests\Controller;

use App\Controller\EntityController;
use App\Tests\Usecase\DeleteEntity\DeleteEntityInteractorStub;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author ~albei <fatal.error.27@gmail.com>
 */
class EntityControllerDeleteEntityTest extends TestCase
{
    private Request $request;
    private EntityController $controller;

    protected function setUp(): void
    {
        $_SERVER['DOCUMENT_ROOT'] = \dirname(__DIR__);

        $this->controller = new EntityController();
        $this->request = new Request();
    }

    public function test_DeleteEntity_GivenWrongContentType_Expect_Http415(): void
    {
        $response = $this->controller->deleteEntity($this->request, new DeleteEntityInteractorStub());

        TestCase::assertEquals(Response::HTTP_UNSUPPORTED_MEDIA_TYPE, $response->getStatusCode());
        TestCase::assertEquals('{"code":-2,"message":"Invalid content-type"}', $response->getContent());
    }

    /**
     * @return array
     */
    public function invalidParamsDataProvider(): array
    {
        return [
            [['date' => '31-12-2020'], '{"code":-1,"message":"Parameter date should be have the following format: YYYY-MM-TT"}'],
            [['date' => '12-31-2020'], '{"code":-1,"message":"Parameter date should be have the following format: YYYY-MM-TT"}'],
            [['date' => '2020-1-1'], '{"code":-1,"message":"Parameter date should be have the following format: YYYY-MM-TT"}'],
            [['date' => '2020-1-01'], '{"code":-1,"message":"Parameter date should be have the following format: YYYY-MM-TT"}'],
            [['date' => '2020-01-1'], '{"code":-1,"message":"Parameter date should be have the following format: YYYY-MM-TT"}'],
            [['date' => '20-1-1'], '{"code":-1,"message":"Parameter date should be have the following format: YYYY-MM-TT"}'],
            [['date' => '20-01-1'], '{"code":-1,"message":"Parameter date should be have the following format: YYYY-MM-TT"}'],
            [['date' => '20-1-01'], '{"code":-1,"message":"Parameter date should be have the following format: YYYY-MM-TT"}'],
            [['employerId' => 'abc'], '{"code":-1,"message":"Invalid params transmitted"}'],
            [['employerWorkingTimeId' => 'abc'], '{"code":-1,"message":"Invalid params transmitted"}']
        ];
    }

    /**
     * @dataProvider invalidParamsDataProvider
     * @param array $params
     * @param string $json
     */
    public function test_DeleteEntity_GivenInvalidParams_Expect_Http400(array $params, string $json): void
    {
        $this->request->headers->set('CONTENT_TYPE', 'application/json');

        foreach ($params as $name => $value) {
            $this->request->query->set($name, $value);
        }

        $response = $this->controller->deleteEntity($this->request, new DeleteEntityInteractorStub());

        TestCase::assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
        TestCase::assertEquals($json, $response->getContent());
    }

    public function test_DeleteEntity_Expect_Http200(): void
    {
        $this->request->headers->set('CONTENT_TYPE', 'application/json');
        $this->request->query->set('employerId', 1);
        $this->request->query->set('employerWorkingTimeId', 1);

        $response = $this->controller->deleteEntity($this->request, new DeleteEntityInteractorStub());

        TestCase::assertEquals(Response::HTTP_OK, $response->getStatusCode());
        TestCase::assertEquals('{"code":1,"entities":[]}', $response->getContent());
    }
}