<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreatecategoryAPIRequest;
use App\Http\Requests\API\UpdatecategoryAPIRequest;
use App\Models\category;
use App\Repositories\categoryRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController as InfyOmBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use InfyOm\Generator\Utils\ResponseUtil;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class categoryController
 * @package App\Http\Controllers\API
 */

class categoryAPIController extends InfyOmBaseController
{
    /** @var  categoryRepository */
    private $categoryRepository;

    public function __construct(categoryRepository $categoryRepo)
    {
        $this->categoryRepository = $categoryRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/categories",
     *      summary="Get a listing of the categories.",
     *      tags={"category"},
     *      description="Get all categories",
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
     *                  @SWG\Items(ref="#/definitions/category")
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
        $this->categoryRepository->pushCriteria(new RequestCriteria($request));
        $this->categoryRepository->pushCriteria(new LimitOffsetCriteria($request));
        $categories = $this->categoryRepository->all();

        return $this->sendResponse($categories->toArray(), 'categories retrieved successfully');
    }

    /**
     * @param CreatecategoryAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/categories",
     *      summary="Store a newly created category in storage",
     *      tags={"category"},
     *      description="Store category",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="category that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/category")
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
     *                  ref="#/definitions/category"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreatecategoryAPIRequest $request)
    {
        $input = $request->all();

        $categories = $this->categoryRepository->create($input);

        return $this->sendResponse($categories->toArray(), 'category saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/categories/{id}",
     *      summary="Display the specified category",
     *      tags={"category"},
     *      description="Get category",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of category",
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
     *                  ref="#/definitions/category"
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
        /** @var category $category */
        $category = $this->categoryRepository->find($id);

        if (empty($category)) {
            return Response::json(ResponseUtil::makeError('category not found'), 404);
        }

        return $this->sendResponse($category->toArray(), 'category retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdatecategoryAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/categories/{id}",
     *      summary="Update the specified category in storage",
     *      tags={"category"},
     *      description="Update category",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of category",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="category that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/category")
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
     *                  ref="#/definitions/category"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdatecategoryAPIRequest $request)
    {
        $input = $request->all();

        /** @var category $category */
        $category = $this->categoryRepository->find($id);

        if (empty($category)) {
            return Response::json(ResponseUtil::makeError('category not found'), 404);
        }

        $category = $this->categoryRepository->update($input, $id);

        return $this->sendResponse($category->toArray(), 'category updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/categories/{id}",
     *      summary="Remove the specified category from storage",
     *      tags={"category"},
     *      description="Delete category",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of category",
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
        /** @var category $category */
        $category = $this->categoryRepository->find($id);

        if (empty($category)) {
            return Response::json(ResponseUtil::makeError('category not found'), 404);
        }

        $category->delete();

        return $this->sendResponse($id, 'category deleted successfully');
    }
}
