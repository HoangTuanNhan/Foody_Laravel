<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\CreatecategoryRequest;
use App\Http\Requests\UpdatecategoryRequest;
use App\Repositories\categoryRepository;
use App\Http\Controllers\AppBaseController as InfyOmBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class categoryController extends InfyOmBaseController {

    /** @var  categoryRepository */
    private $categoryRepository;

    public function __construct(categoryRepository $categoryRepo) {
        $this->categoryRepository = $categoryRepo;
    }

    /**
     * Display a listing of the category.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request) {
        $this->categoryRepository->pushCriteria(new RequestCriteria($request));
        $categories = $this->categoryRepository->paginate(1);

        return view('categories.index')
                        ->with('categories', $categories);
    }

    /**
     * Show the form for creating a new category.
     *
     * @return Response
     */
    public function create() {
        if (!\Gate::denies('user', $this->categoryRepository)) {
            return redirect('categories');
        }
        return view('categories.create');
    }

    /**
     * Store a newly created category in storage.
     *
     * @param CreatecategoryRequest $request
     *
     * @return Response
     */
    public function store(CreatecategoryRequest $request) {
        if (!\Gate::denies('user', $this->categoryRepository)) {
            return redirect('categories');
        }
        $file = $request->file('image');
        $file_name = $file->getClientOriginalName();
        $ext_file = $file->getClientOriginalExtension();
        $file_name = "category-" . time() . "." . $ext_file;

        $destinationPath = 'uploads';
        $file->move($destinationPath, $file_name);
        $input = ['name' => $request->input('name'), 'image' => $file_name];
        $category = $this->categoryRepository->create($input);
        Flash::success('category saved successfully.');
        return redirect(route('categories.index'));
    }

    /**
     * Display the specified category.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id) {

        $category = $this->categoryRepository->findWithoutFail($id);

        if (empty($category)) {
            Flash::error('category not found');

            return redirect(route('categories.index'));
        }

        return view('categories.show')->with('category', $category);
    }

    /**
     * Show the form for editing the specified category.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id) {
        if (!\Gate::denies('user', $this->categoryRepository)) {
            return redirect('categories');
        }
        $category = $this->categoryRepository->findWithoutFail($id);

        if (empty($category)) {
            Flash::error('category not found');

            return redirect(route('categories.index'));
        }

        return view('categories.edit')->with('category', $category);
    }

    /**
     * Update the specified category in storage.
     *
     * @param  int              $id
     * @param UpdatecategoryRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatecategoryRequest $request) {
         if (!\Gate::denies('user', $this->categoryRepository)) {
            return redirect('categories');
        }
        $category = $this->categoryRepository->findWithoutFail($id);
        if (empty($category)) {
            Flash::error('category not found');
            return redirect(route('categories.index'));
        }
        $input = $request->all();
        $file = $request->file('image');
        if ($file != null) {
            $file_name = $file->getClientOriginalName();
            $ext_file = $file->getClientOriginalExtension();
            $file_name = "category-" . time() . "." . $ext_file;
            $input['image'] = $file_name;
            $destinationPath = 'uploads';
            $file->move($destinationPath, $file_name);
            if (\File::exists(public_path() . '\uploads' . '\\' . $category->image)) {
                \File::delete(public_path() . '\uploads' . '\\' . $category->image);
            }
        } else {
            $input['image'] = $category->image;
        }
        $category = $this->categoryRepository->update($input, $id);

        Flash::success('category updated successfully.');

        return redirect(route('categories.index'));
    }

    /**
     * Remove the specified category from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id) {
         if (!\Gate::denies('user', $this->categoryRepository)) {
            return redirect('categories');
        }
        $category = $this->categoryRepository->findWithoutFail($id);

        if (empty($category)) {
            Flash::error('category not found');

            return redirect(route('categories.index'));
        }

        $this->categoryRepository->delete($id);
        if (\File::exists(public_path() . '\uploads' . '\\' . $category->image)) {
            \File::delete(public_path() . '\uploads' . '\\' . $category->image);
        }

        Flash::success('category deleted successfully.');

        return redirect(route('categories.index'));
    }

}
