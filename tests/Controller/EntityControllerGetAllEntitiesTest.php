<?php

namespace App\Tests\Controller;

use App\Controller\EntityController;
use App\Tests\Usecase\GetAllEntities\GetAllEntitiesInteractorStub;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author ~albei <fatal.error.27@gmail.com>
 */
class EntityControllerGetAllEntitiesTest extends TestCase
{
    private Request $request;
    private EntityController $controller;

    protected function setUp(): void
    {
        $_SERVER['DOCUMENT_ROOT'] = \dirname(__DIR__);

        $this->controller = new EntityController();
        $this->request = new Request();
    }

    public function test_GetAllEntities_GivenWrongContentType_Expect_Http415(): void
    {
        $response = $this->controller->getAllEntities($this->request, new GetAllEntitiesInteractorStub());

        TestCase::assertEquals(Response::HTTP_UNSUPPORTED_MEDIA_TYPE, $response->getStatusCode());
        TestCase::assertEquals('{"code":-2,"message":"Invalid content-type"}', $response->getContent());
    }

    public function test_GetAllEntities_GivenEmptyEmployerId_Expect_Http400(): void
    {
        $this->request->headers->set('CONTENT_TYPE', 'application/json');
        $this->request->query->set('employerId', 'abc');

        $response = $this->controller->getAllEntities($this->request, new GetAllEntitiesInteractorStub());

        TestCase::assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
        TestCase::assertEquals('{"code":-1,"message":"Invalid params transmitted"}', $response->getContent());
    }

    public function test_GetAllEntities_Expect_Http200(): void
    {
        $this->request->headers->set('CONTENT_TYPE', 'application/json');
        $this->request->query->set('employerId', 1);

        $response = $this->controller->getAllEntities($this->request, new GetAllEntitiesInteractorStub());

        TestCase::assertEquals(Response::HTTP_OK, $response->getStatusCode());
        TestCase::assertEquals(
            '{"code":1,"entities":[{"no":2,"delta":-45,"deltaFormatted":"-00:45","days":[{"weekday":1,"date":"2020-01-06","begin":"09:08","end":"16:52","mode":"working","delta":30,"break":30,"employerId":1,"employerName":"Google","workingTimeId":1,"workingTimeDescription":"Fulltime"},{"weekday":2,"date":"2020-01-07","begin":"09:47","end":"17:59","mode":"working","delta":-120,"break":30,"employerId":1,"employerName":"Google","workingTimeId":1,"workingTimeDescription":"Fulltime"},{"weekday":3,"date":"2020-01-08","begin":"07:59","end":"15:55","mode":"working","delta":0,"break":30,"employerId":1,"employerName":"Google","workingTimeId":1,"workingTimeDescription":"Fulltime"},{"weekday":4,"date":"2020-01-09","begin":"09:43","end":"19:13","mode":"working","delta":2,"break":30,"employerId":1,"employerName":"Google","workingTimeId":1,"workingTimeDescription":"Fulltime"},{"weekday":5,"date":"2020-01-10","begin":"09:35","end":"18:14","mode":"working","delta":43,"break":30,"employerId":1,"employerName":"Google","workingTimeId":1,"workingTimeDescription":"Fulltime"}]}]}',
            $response->getContent()
        );
    }
}