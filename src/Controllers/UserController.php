<?php

namespace Chunker\Base\Controllers;

use Chunker\Base\Models\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
	/*
	 * Show list of users
	 */
	public function index()
	{
		$all_users = User::orderBy('login');
		$active_users = $all_users->get();
		$deleted_users = $all_users->onlyTrashed()->get();

		return view('Base::users.index', compact('active_users', 'deleted_users'));
	}


	/*
	 * Show page for adding user
	 */
	public function create()
	{
		return view('Base::users.create');
	}


	/*
	 * Storing user
	 */
	public function store(Request $request)
	{
		$data = $request->only([
			'login',
			'password',
			'email',
			'name'
		]);

		$user = User::create($data);

		return redirect()->route('admin.users.edit', $user);
	}


	/*
	 * Show user's data for edit
	 */
	public function edit(User $user)
	{
		$total = User::count();
		return view('Base::users.edit', compact('user', 'total'));
	}


	/*
	 * Updating user
	 */
	public function update(Request $request, User $user)
	{
		$data = $request->only([
			'login',
			'password',
			'email',
			'name'
		]);

		$user->update($data);

		return redirect()->back();
	}


	/*
	 * Deleting user
	 */


	/*
	 * Show user's authorizations journal
	 */
	public function authorizations(User $user)
	{
		$authorizations = $user->authorizations()->recent()->paginate();
		return view('Base::users.authorizations', compact('user', 'authorizations'));
	}
}