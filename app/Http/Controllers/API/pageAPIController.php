<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreatepageAPIRequest;
use App\Http\Requests\API\UpdatepageAPIRequest;
use App\Models\page;
use App\Repositories\pageRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController as InfyOmBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use InfyOm\Generator\Utils\ResponseUtil;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class pageController
 * @package App\Http\Controllers\API
 */

class pageAPIController extends InfyOmBaseController
{
    /** @var  pageRepository */
    private $pageRepository;

    public function __construct(pageRepository $pageRepo)
    {
        $this->pageRepository = $pageRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/pages",
     *      summary="Get a listing of the pages.",
     *      tags={"page"},
     *      description="Get all pages",
     *      produces={"application/json"},
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  type="array",
     *                  @SWG\Items(ref="#/definitions/page")
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function index(Request $request)
    {
        $this->pageRepository->pushCriteria(new RequestCriteria($request));
        $this->pageRepository->pushCriteria(new LimitOffsetCriteria($request));
        $pages = $this->pageRepository->all();

        return $this->sendResponse($pages->toArray(), 'pages retrieved successfully');
    }

    /**
     * @param CreatepageAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/pages",
     *      summary="Store a newly created page in storage",
     *      tags={"page"},
     *      description="Store page",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="page that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/page")
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/page"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreatepageAPIRequest $request)
    {
        $input = $request->all();

        $pages = $this->pageRepository->create($input);

        return $this->sendResponse($pages->toArray(), 'page saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/pages/{id}",
     *      summary="Display the specified page",
     *      tags={"page"},
     *      description="Get page",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of page",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/page"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function show($id)
    {
        /** @var page $page */
        $page = $this->pageRepository->find($id);

        if (empty($page)) {
            return Response::json(ResponseUtil::makeError('page not found'), 404);
        }

        return $this->sendResponse($page->toArray(), 'page retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdatepageAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/pages/{id}",
     *      summary="Update the specified page in storage",
     *      tags={"page"},
     *      description="Update page",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of page",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="page that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/page")
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/page"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdatepageAPIRequest $request)
    {
        $input = $request->all();

        /** @var page $page */
        $page = $this->pageRepository->find($id);

        if (empty($page)) {
            return Response::json(ResponseUtil::makeError('page not found'), 404);
        }

        $page = $this->pageRepository->update($input, $id);

        return $this->sendResponse($page->toArray(), 'page updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/pages/{id}",
     *      summary="Remove the specified page from storage",
     *      tags={"page"},
     *      description="Delete page",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of page",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  type="string"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function destroy($id)
    {
        /** @var page $page */
        $page = $this->pageRepository->find($id);

        if (empty($page)) {
            return Response::json(ResponseUtil::makeError('page not found'), 404);
        }

        $page->delete();

        return $this->sendResponse($id, 'page deleted successfully');
    }
}
