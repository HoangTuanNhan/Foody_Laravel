<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\CreatepageRequest;
use App\Http\Requests\UpdatepageRequest;
use App\Repositories\pageRepository;
use App\Http\Controllers\AppBaseController as InfyOmBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class pageController extends InfyOmBaseController {

    /** @var  pageRepository */
    private $pageRepository;

    public function __construct(pageRepository $pageRepo) {
        $this->pageRepository = $pageRepo;
    }

    /**
     * Display a listing of the page.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request) {
        $this->pageRepository->pushCriteria(new RequestCriteria($request));
        $pages = $this->pageRepository->paginate(5);

        return view('pages.index')
                        ->with('pages', $pages);
    }

    /**
     * Show the form for creating a new page.
     *
     * @return Response
     */
    public function create() {
        if (!\Gate::denies('user', $this->pageRepository)) {
            return redirect('pages');
        }
        return view('pages.create');
    }

    /**
     * Store a newly created page in storage.
     *
     * @param CreatepageRequest $request
     *
     * @return Response
     */
    public function store(CreatepageRequest $request) {
        if (!\Gate::denies('user', $this->pageRepository)) {
            return redirect('pages');
        }
        $input = $request->all();

        $page = $this->pageRepository->create($input);

        Flash::success('page saved successfully.');

        return redirect(route('pages.index'));
    }

    /**
     * Display the specified page.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id) {
        $page = $this->pageRepository->findWithoutFail($id);

        if (empty($page)) {
            Flash::error('page not found');

            return redirect(route('pages.index'));
        }

        return view('pages.show')->with('page', $page);
    }

    /**
     * Show the form for editing the specified page.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id) {
        if (!\Gate::denies('user', $this->pageRepository)) {
            return redirect('pages');
        }
        $page = $this->pageRepository->findWithoutFail($id);

        if (empty($page)) {
            Flash::error('page not found');

            return redirect(route('pages.index'));
        }

        return view('pages.edit')->with('page', $page);
    }

    /**
     * Update the specified page in storage.
     *
     * @param  int              $id
     * @param UpdatepageRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatepageRequest $request) {
        if (!\Gate::denies('user', $this->pageRepository)) {
            return redirect('pages');
        }
        $page = $this->pageRepository->findWithoutFail($id);

        if (empty($page)) {
            Flash::error('page not found');

            return redirect(route('pages.index'));
        }

        $page = $this->pageRepository->update($request->all(), $id);

        Flash::success('page updated successfully.');

        return redirect(route('pages.index'));
    }

    /**
     * Remove the specified page from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id) {
        if (!\Gate::denies('user', $this->pageRepository)) {
            return redirect('pages');
        }
        $page = $this->pageRepository->findWithoutFail($id);

        if (empty($page)) {
            Flash::error('page not found');

            return redirect(route('pages.index'));
        }

        $this->pageRepository->delete($id);

        Flash::success('page deleted successfully.');

        return redirect(route('pages.index'));
    }

}
