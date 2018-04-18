<?php

namespace App\Http\Controllers;

use EllipseSynergie\ApiResponse\Contracts\Response;
use App\User;
use App\Transformer\UserTransformer;
use Illuminate\Http\Request;

/**
 *
 * @author Sandro
 *
 */
class UserController extends Controller
{
	protected $respose;
	
	/**
	 *
	 * @param Response $response
	 */
	public function __construct(Response $response) {
		
		$this->response = $response;
	}
	
	/**
	 *
	 * @return unknown
	 */
	public function index() {
		
		$users = User::paginate ( 15 );
		
		return $this->response->withPaginator ( $users, new UserTransformer() );
	}
	
	/**
	 *
	 * @param int $id
	 * @return mixed
	 */
	public function show($id) {
		$user = User::find ( $id );
		
		if (! $user) {
			return $this->response->errorNotFound ( 'User Not Found' );
		}
		
		return $this->response->withItem ( $user, new UserTransformer () );
	}
	
	/**
	 *
	 * @param string $name
	 * @param string $email
	 * @return mixed
	 */
	public function find($name, $email) {
		
		
		$user = User::query()
		->where('name', 'like', "%{$name}%")
		->where('email', 'like', "%{$email}%")
		->paginate(15);
		
		$userData = $user->toArray();
		if (empty($userData)) {
			return $this->response->errorNotFound ( 'User Not Found' );
		}
		
		return $this->response->withPaginator( $user, new UserTransformer () );
		
	}
	
	/**
	 * 
	 * @param Request $request
	 * @return mixed
	 */
	public function store(Request $request) {
		
		if ($request->isMethod ( 'put' )) {
			
			$user = User::find ( $request->id );
			if (! $user) {
				return $this->response->errorNotFound ( 'User Not Found' );
			}
		} else {
			$user = new User();
		}
		
		$user->id = $request->input ( 'id' );
		$user->name = $request->input ( 'name' );
		$user->email = $request->input ( 'email' );
		$user->password = 'aaa';
		
		if ($user->save ()) {
			return $this->response->withItem ( $user, new UserTransformer () );
		} else {
			return $this->response->errorInternalError ( 'Could not updated/created a user' );
		}
		
	}
	
	/**
	 *
	 * @param int $id
	 * @return mixed
	 */
	public function destroy($id) {
		
		$user = User::find ( $id );
		if (! $user) {
			return $this->response->errorNotFound ( 'Task Not Found' );
		}
		
		if ($user->delete ()) {
			return $this->response->withItem ( $user, new UserTransformer () );
		} else {
			return $this->response->errorInternalError ( 'Could not delete a user' );
		}
	}
}
