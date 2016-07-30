<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\CreateuserRequest;
use App\Http\Requests\UpdateuserRequest;
use App\Repositories\userRepository;
use App\Http\Controllers\AppBaseController as InfyOmBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class userController extends InfyOmBaseController {

    /** @var  userRepository */
    private $userRepository;

    public function __construct(userRepository $userRepo) {
        $this->userRepository = $userRepo;
    }

    /**
     * Display a listing of the user.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request) {
        $this->userRepository->pushCriteria(new RequestCriteria($request));
        $users = $this->userRepository->paginate(2);

        return view('users.index')
                        ->with('users', $users);
    }

    /**
     * Show the form for creating a new user.
     *
     * @return Response
     */
    public function create() {
        if (!\Gate::denies('user', $this->userRepository)) {
            return redirect('users');
        }
        return view('users.create');
    }

    /**
     * Store a newly created user in storage.
     *
     * @param CreateuserRequest $request
     *
     * @return Response
     */
    public function store(CreateuserRequest $request) {
        if (!\Gate::denies('user', $this->userRepository)) {
            return redirect('users');
        }
        $input = $request->all();
        $file = $request->file('avatar');
        $file_name = $file->getClientOriginalName();
        $ext_file = $file->getClientOriginalExtension();
        $file_name = "user-" . time() . "." . $ext_file;
        $destinationPath = 'uploads';
        $file->move($destinationPath, $file_name);
//        $input = ['name' => $request->input('name'), 'email' => $request->input('email'), 'avatar' => $file_name, 'password' => $request->input('password'), 'is_admin' => $request->input('is_admin')];
        $input['avatar'] = $file_name;
        $input['password'] = bcrypt($input['password']);
        //save to db
        $user = $this->userRepository->create($input);
        Flash::success('user saved successfully.');
        return redirect(route('users.index'));
    }

    /**
     * Display the specified user.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id) {
        $user = $this->userRepository->findWithoutFail($id);

        if (empty($user)) {
            Flash::error('user not found');

            return redirect(route('users.index'));
        }

        return view('users.show')->with('user', $user);
    }

    /**
     * Show the form for editing the specified user.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id) {
        if (!\Gate::denies('user', $this->userRepository)) {
            return redirect('users');
        }
        $user = $this->userRepository->findWithoutFail($id);

        if (empty($user)) {
            Flash::error('user not found');

            return redirect(route('users.index'));
        }

        return view('users.edit')->with('user', $user);
    }

    /**
     * Update the specified user in storage.
     *
     * @param  int              $id
     * @param UpdateuserRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateuserRequest $request) {
        if (!\Gate::denies('user', $this->userRepository)) {
            return redirect('users');
        }
        $user = $this->userRepository->findWithoutFail($id);

        if (empty($user)) {
            Flash::error('user not found');
            return redirect(route('users.index'));
        };
        $input = $request->all();
        $input['email'] = $user->email;
        $file = $request->file('avatar');
        if ($file != null) {
            $file_name = $file->getClientOriginalName();
            $ext_name = $file->getClientOriginalExtension();
            $file_name = "user-" . time() . "." . $ext_name;
            $input['avatar'] = $file_name;
            $input['password'] = bcrypt($input['password']);

            $destinationPath = 'uploads';
            $file->move($destinationPath, $file_name);
            //delete old file
            if (\File::exists(public_path() . '\uploads' . '\\' . $user->avatar)) {
                \File::delete(public_path() . '\uploads' . '\\' . $user->avatar);
            }
        } else {
            $input['avatar'] = $user->avatar;
            $input['password'] = bcrypt($input['password']);
        }
        $user = $this->userRepository->update($input, $id);
        Flash::success('user updated successfully.');

        return redirect(route('users.index'));
    }

    /**
     * Remove the specified user from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id) {
        if (!\Gate::denies('user', $this->userRepository)) {
            return redirect('users');
        }
        $user = $this->userRepository->findWithoutFail($id);

        if (empty($user)) {
            Flash::error('user not found');

            return redirect(route('users.index'));
        }

        $this->userRepository->delete($id);
        if (\File::exists(public_path() . '\uploads' . '\\' . $user->avatar)) {
            \File::delete(public_path() . '\uploads' . '\\' . $user->avatar);
        }

        Flash::success('user deleted successfully.');

        return redirect(route('users.index'));
    }

}
