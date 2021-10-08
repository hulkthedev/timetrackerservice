<?php

namespace App\Tests\Controller;

use App\Controller\EntityController;
use App\Tests\Usecase\UpdateEntity\UpdateEntityInteractorStub;
use App\Usecase\Modes;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author ~albei <fatal.error.27@gmail.com>
 */
class EntityControllerUpdateEntityTest extends TestCase
{
    private Request $request;
    private EntityController $controller;

    protected function setUp(): void
    {
        $_SERVER['DOCUMENT_ROOT'] = \dirname(__DIR__);

        $this->controller = new EntityController();
        $this->request = new Request();
    }

    public function test_UpdateEntity_GivenWrongContentType_Expect_Http415(): void
    {
        $response = $this->controller->updateEntity($this->request, new UpdateEntityInteractorStub());

        TestCase::assertEquals(Response::HTTP_UNSUPPORTED_MEDIA_TYPE, $response->getStatusCode());
        TestCase::assertEquals('{"code":-2,"message":"Invalid content-type"}', $response->getContent());
    }

    /**
     * @return array
     */
    public function invalidJsonParamsDataProvider(): array
    {
        return [
            [['begin' => 'abc'], '{"code":-3,"message":"Invalid json"}'],
            [['begin' => 'abcdefghi'], '{"code":-3,"message":"Invalid json"}'],         // to short
            [['begin' => 'abcdefghijklmnop'], '{"code":-3,"message":"Invalid json"}'],  // to long

            [['end' => 'abc'], '{"code":-3,"message":"Invalid json"}'],
            [['end' => 'abcdefghi'], '{"code":-3,"message":"Invalid json"}'],           // to short
            [['end' => 'abcdefghijklmnop'], '{"code":-3,"message":"Invalid json"}'],    // to long

            [['break' => 'abc'], '{"code":-3,"message":"Invalid json"}'],

            [['mode' => 1], '{"code":-3,"message":"Invalid json"}'],
            [['mode' => 'party'], '{"code":-3,"message":"Invalid json"}'],
        ];
    }

    /**
     * @dataProvider invalidJsonParamsDataProvider
     * @param array $params
     * @param string $json
     */
    public function test_UpdateEntity_GivenInvalidJsonParams_Expect_Http400(array $params, string $json): void
    {
        $this->request->headers->set('CONTENT_TYPE', 'application/json');

        foreach ($params as $name => $value) {
            $this->request->query->set($name, $value);
        }

        $response = $this->controller->updateEntity($this->request, new UpdateEntityInteractorStub());

        TestCase::assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
        TestCase::assertEquals($json, $response->getContent());
    }

    /**
     * @return array
     */
    public function invalidPathParamsDataProvider(): array
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
     * @dataProvider invalidPathParamsDataProvider
     * @param array $params
     * @param string $json
     */
    public function test_UpdateEntity_GivenInvalidPathParams_Expect_Http400(array $params, string $json): void
    {
        $this->request->initialize([], [], [], [], [], [], $this->getRequestBodyAsJson());
        $this->request->headers->set('CONTENT_TYPE', 'application/json');

        foreach ($params as $name => $value) {
            $this->request->query->set($name, $value);
        }

        $response = $this->controller->updateEntity($this->request, new UpdateEntityInteractorStub());

        TestCase::assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
        TestCase::assertEquals($json, $response->getContent());
    }

    public function test_UpdateEntity_Expect_Http200(): void
    {
        $this->request->initialize([], [], [], [], [], [], $this->getRequestBodyAsJson());
        $this->request->headers->set('CONTENT_TYPE', 'application/json');
        $this->request->query->set('date', '2020-01-01');
        $this->request->query->set('employerId', 1);
        $this->request->query->set('employerWorkingTimeId', 1);

        $response = $this->controller->updateEntity($this->request, new UpdateEntityInteractorStub());

        TestCase::assertEquals(Response::HTTP_OK, $response->getStatusCode());
        TestCase::assertEquals('{"code":1,"entities":[]}', $response->getContent());
    }

    /**
     * @return string
     */
    private function getRequestBodyAsJson(): string
    {
        return json_encode([
            'begin' => 1122334455,
            'end' => 6677889900,
            'mode' => Modes::MODE_WORKING,
            'break' => 30,
        ]);
    }
}