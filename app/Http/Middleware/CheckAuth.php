<?php

namespace Chunker\Base\Http\Middleware;

use Chunker\Base\Events\UserRequestedApp;
use Closure;
use Auth;
use Illuminate\Http\Request;

/**
 * Посредник проверки авторизации и прав пользователя
 *
 * @package Chunker\Base\Http\Middleware
 */
class CheckAuth
{
	/**
	 * Функция отправки ответа
	 *
	 * @param Request    $request запрос на который необходимо отправить ответ
	 * @param string     $message сообщение для ответа
	 * @param int|string $status код статуса
	 *
	 * @return \Illuminate\Http\Response
	 */
	protected function responses($request, $message, $status){
		if ($request->ajax()) {
			/** Ответ при асинхронном запросе */
			return response($message, $status);
		} else {
			/** Ответ при GET-запросе */
			return response()->view('base::auth.login', [], $status);
		}
	}


	public function handle($request, Closure $next){
		/** Если пользователь не авторизован */
		if (Auth::guest()) {
			return $this->responses($request, 'Unauthorized', 401);
		} /** Если у пользователя нет прав */
		elseif (!Auth::user()->is_admin_access) {
			return $this->responses($request, 'Forbidden', 403);
		} /** Регистрация запроса пользователя */
		else {
			event(new UserRequestedApp(Auth::user()));
		}

		return $next($request);
	}
}