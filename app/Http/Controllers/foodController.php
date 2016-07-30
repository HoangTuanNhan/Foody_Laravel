<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\CreatefoodRequest;
use App\Http\Requests\UpdatefoodRequest;
use App\Repositories\foodRepository;
use App\Http\Controllers\AppBaseController as InfyOmBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class foodController extends InfyOmBaseController {

    /** @var  foodRepository */
    private $foodRepository;

    public function __construct(foodRepository $foodRepo) {
        $this->foodRepository = $foodRepo;
    }

    /**
     * Display a listing of the food.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request) {
        $this->foodRepository->pushCriteria(new RequestCriteria($request));
        $foods = $this->foodRepository->paginate(1);

        return view('foods.index')
                        ->with('foods', $foods);
    }

    /**
     * Show the form for creating a new food.
     *
     * @return Response
     */
    public function create() {
        if (!\Gate::denies('user', $this->foodRepository)) {
            return redirect('foods');
        }
        $categories = \App\Models\category::all(['id', 'name']);
        $array1 = array();
        foreach ($categories as $cat) {
            $array1[$cat->id] = $cat->name;
        }
        $array2 = array();
        $users = \App\Models\user::all(['id', 'name']);
        foreach ($users as $user) {
            $array2[$user->id] = $user->name;
        }
        return view('foods.create')->with('categories', $array1)->with('users', $array2);
    }

    /**
     * Store a newly created food in storage.
     *
     * @param CreatefoodRequest $request
     *
     * @return Response
     */
    public function store(CreatefoodRequest $request) {
        if (!\Gate::denies('user', $this->foodRepository)) {
            return redirect('foods');
        }
        $input = $request->all();
        $file = $request->file('image');
        $file_name = $file->getClientOriginalExtension();
        $ext_name = $file->getClientOriginalExtension();
        $file_name = "food-" . time() . "." . $ext_name;
        $input['image'] = $file_name;
        $dePath = 'uploads';
        $file->move($dePath, $file_name);
        $food = $this->foodRepository->create($input);
        Flash::success('food saved successfully.');
        return redirect(route('foods.index'));
    }

    /**
     * Display the specified food.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id) {
        $food = $this->foodRepository->findWithoutFail($id);

        if (empty($food)) {
            Flash::error('food not found');

            return redirect(route('foods.index'));
        }

        return view('foods.show')->with('food', $food);
    }

    /**
     * Show the form for editing the specified food.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id) {
        if (!\Gate::denies('user', $this->foodRepository)) {
            return redirect('foods');
        }
        $food = $this->foodRepository->findWithoutFail($id);
        $categories = \App\Models\category::all(['id', 'name']);
        $array1 = array();
        foreach ($categories as $cat) {
            $array1[$cat->id] = $cat->name;
        }
        $array2 = array();
        $users = \App\Models\user::all(['id', 'name']);
        foreach ($users as $user) {
            $array2[$user->id] = $user->name;
        }
        if (empty($food)) {
            Flash::error('food not found');

            return redirect(route('foods.index'));
        }

        return view('foods.edit')->with('food', $food)->with('categories', $array1)->with('users', $array2);
    }

    /**
     * Update the specified food in storage.
     *
     * @param  int              $id
     * @param UpdatefoodRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatefoodRequest $request) {
        if (!\Gate::denies('user', $this->foodRepository)) {
            return redirect('foods');
        }
        $food = $this->foodRepository->findWithoutFail($id);
        if (empty($food)) {
            Flash::error('food not found');

            return redirect(route('foods.index'));
        }

        $input = $request->all();
        $file = $request->file('image');
        if ($file != null) {
            $file_name = $file->getClientOriginalName();
            $ext_name = $file->getClientOriginalExtension();
            $file_name = "food-" . time() . "." . $ext_name;
            $input['image'] = $file_name;
            $dePath = 'uploads';
            $file->move($dePath, $file_name);
        } else {
            $input['image'] = $food->image;
        }

        $food = $this->foodRepository->update($input, $id);

        Flash::success('food updated successfully.');

        return redirect(route('foods.index'));
    }

    /**
     * Remove the specified food from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id) {
        if (!\Gate::denies('user', $this->foodRepository)) {
            return redirect('foods');
        }
        $food = $this->foodRepository->findWithoutFail($id);

        if (empty($food)) {
            Flash::error('food not found');

            return redirect(route('foods.index'));
        }

        $this->foodRepository->delete($id);
         if (\File::exists(public_path() . '\uploads' . '\\' . $food->avatar)) {
                \File::delete(public_path() . '\uploads' . '\\' . $food->avatar);
            }

        Flash::success('food deleted successfully.');

        return redirect(route('foods.index'));
    }

}
