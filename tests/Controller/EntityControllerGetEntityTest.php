<?php

namespace App\Tests\Controller;

use App\Controller\EntityController;
use App\Tests\Usecase\GetEntity\GetEntityInteractorStub;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use function dirname;

/**
 * @author ~albei <fatal.error.27@gmail.com>
 */
class EntityControllerGetEntityTest extends TestCase
{
    public function test_GetEntity_Expect_Http200(): void
    {
        $_SERVER['DOCUMENT_ROOT'] = dirname(__DIR__);

        $request = new Request();
        $request->headers->set('CONTENT_TYPE', 'application/json');
        $request->query->set('employerId', 1);
        $request->query->set('employerWorkingTimeId', 1);

        $controller = new EntityController();
        $response = $controller->getEntity($request, new GetEntityInteractorStub());

        TestCase::assertEquals(Response::HTTP_OK, $response->getStatusCode());
        TestCase::assertEquals(
            '{"code":1,"entities":[{"weekday":1,"date":"2020-01-06","begin":"09:08","end":"16:52","mode":"working","delta":30,"break":30,"employerId":1,"employerName":"Google","workingTimeId":1,"workingTimeDescription":"Fulltime"}]}',
            $response->getContent()
        );
    }
}