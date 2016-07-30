<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreatefoodAPIRequest;
use App\Http\Requests\API\UpdatefoodAPIRequest;
use App\Models\food;
use App\Repositories\foodRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController as InfyOmBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use InfyOm\Generator\Utils\ResponseUtil;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class foodController
 * @package App\Http\Controllers\API
 */

class foodAPIController extends InfyOmBaseController
{
    /** @var  foodRepository */
    private $foodRepository;

    public function __construct(foodRepository $foodRepo)
    {
        $this->foodRepository = $foodRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/foods",
     *      summary="Get a listing of the foods.",
     *      tags={"food"},
     *      description="Get all foods",
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
     *                  @SWG\Items(ref="#/definitions/food")
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
        $this->foodRepository->pushCriteria(new RequestCriteria($request));
        $this->foodRepository->pushCriteria(new LimitOffsetCriteria($request));
        $foods = $this->foodRepository->all();

        return $this->sendResponse($foods->toArray(), 'foods retrieved successfully');
    }

    /**
     * @param CreatefoodAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/foods",
     *      summary="Store a newly created food in storage",
     *      tags={"food"},
     *      description="Store food",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="food that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/food")
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
     *                  ref="#/definitions/food"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreatefoodAPIRequest $request)
    {
        $input = $request->all();

        $foods = $this->foodRepository->create($input);

        return $this->sendResponse($foods->toArray(), 'food saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/foods/{id}",
     *      summary="Display the specified food",
     *      tags={"food"},
     *      description="Get food",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of food",
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
     *                  ref="#/definitions/food"
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
        /** @var food $food */
        $food = $this->foodRepository->find($id);

        if (empty($food)) {
            return Response::json(ResponseUtil::makeError('food not found'), 404);
        }

        return $this->sendResponse($food->toArray(), 'food retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdatefoodAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/foods/{id}",
     *      summary="Update the specified food in storage",
     *      tags={"food"},
     *      description="Update food",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of food",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="food that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/food")
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
     *                  ref="#/definitions/food"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdatefoodAPIRequest $request)
    {
        $input = $request->all();

        /** @var food $food */
        $food = $this->foodRepository->find($id);

        if (empty($food)) {
            return Response::json(ResponseUtil::makeError('food not found'), 404);
        }

        $food = $this->foodRepository->update($input, $id);

        return $this->sendResponse($food->toArray(), 'food updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/foods/{id}",
     *      summary="Remove the specified food from storage",
     *      tags={"food"},
     *      description="Delete food",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of food",
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
        /** @var food $food */
        $food = $this->foodRepository->find($id);

        if (empty($food)) {
            return Response::json(ResponseUtil::makeError('food not found'), 404);
        }

        $food->delete();

        return $this->sendResponse($id, 'food deleted successfully');
    }
}
