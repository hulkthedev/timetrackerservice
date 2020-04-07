<?php

namespace App\Tests\Controller;

use App\Controller\EntityController;
use App\Tests\Usecase\GetAllEntities\GetAllEntitiesInteractorStub;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use function dirname;

/**
 * @author ~albei <fatal.error.27@gmail.com>
 */
class EntityControllerGetAllEntitiesTest extends TestCase
{
    public function test_GetAllEntities_Expect_Http200(): void
    {
        $_SERVER['DOCUMENT_ROOT'] = dirname(__DIR__);

        $request = new Request();
        $request->headers->set('CONTENT_TYPE', 'application/json');
        $request->query->set('employerId', 1);

        $controller = new EntityController();
        $response = $controller->getAllEntities($request, new GetAllEntitiesInteractorStub());

        TestCase::assertEquals(Response::HTTP_OK, $response->getStatusCode());
        TestCase::assertEquals(
            '{"code":1,"entities":[{"no":2,"delta":-45,"deltaFormatted":"-00:45","days":[{"weekday":1,"date":"2020-01-06","begin":"09:08","end":"16:52","mode":"working","delta":30,"break":30,"employerId":1,"employerName":"Google","workingTimeId":1,"workingTimeDescription":"Fulltime"},{"weekday":2,"date":"2020-01-07","begin":"09:47","end":"17:59","mode":"working","delta":-120,"break":30,"employerId":1,"employerName":"Google","workingTimeId":1,"workingTimeDescription":"Fulltime"},{"weekday":3,"date":"2020-01-08","begin":"07:59","end":"15:55","mode":"working","delta":0,"break":30,"employerId":1,"employerName":"Google","workingTimeId":1,"workingTimeDescription":"Fulltime"},{"weekday":4,"date":"2020-01-09","begin":"09:43","end":"19:13","mode":"working","delta":2,"break":30,"employerId":1,"employerName":"Google","workingTimeId":1,"workingTimeDescription":"Fulltime"},{"weekday":5,"date":"2020-01-10","begin":"09:35","end":"18:14","mode":"working","delta":43,"break":30,"employerId":1,"employerName":"Google","workingTimeId":1,"workingTimeDescription":"Fulltime"}]}]}',
            $response->getContent()
        );
    }
}