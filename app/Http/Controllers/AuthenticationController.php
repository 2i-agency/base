<?php

namespace Chunker\Base\Http\Controllers;

use Chunker\Base\Events\UserLoggedIn;
use Chunker\Base\Events\UserRequestedApp;
use Chunker\Base\Models\User;
use Chunker\Base\Http\Requests\AuthenticationRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Mail\Message;
use Mail;

class AuthenticationController extends Controller
{
	/*
	 * Аутентификация
	 */
	public function login(AuthenticationRequest $request) {
		$credentials = $request->only(['login', 'password']);
		$user = Auth::getProvider()->retrieveByCredentials($credentials);

		// Успешная аутентификация
		if (!$user->is_blocked && Auth::attempt($credentials, $request->has('remember'))) {
			event(new UserLoggedIn($user, false));
			return back();
		}
		// Аутентификация провалена
		else {
			event(new UserLoggedIn($user, true));

			if ($user->is_blocked)
			{
				flash()->error('Учетная запись <b>' . $user->login . '</b> заблокирована');
			}
			else
			{
				flash()->error('Указан неверный пароль');
			}

			return back()->withInput();
		}
	}


	/*
	 * Деаутентификация
	 */
	public function logout() {
		event(new UserRequestedApp(Auth::user()));
		Auth::logout();

		return back();
	}


	/*
	 * Страница сброса пароля
	 */
	public function showResetPasswordForm() {
		return view('chunker.base::admin.auth.reset');
	}


	/*
	 * Сброс пароля
	 */
	public function resetPassword(Request $request) {
		// Валидация
		$this->validate($request, [
			'login' => 'required'
		], [
			'login.required' => 'Необходимо указать логин или электронный адрес'
		]);


		// Поиск пользователя
		$login = trim($request->get('login'));
		$user = User
			::where('login', $login)
			->orWhere('email', $login)
			->first(['id', 'login', 'email']);


		// Уведомление о неудачном поиске
		if (is_null($user))
		{
			return back()->withErrors('Не&nbsp;найден пользователь с&nbsp;таким логином или&nbsp;электронным адресом');
		}


		// Установка нового пароля
		$password = substr(md5(time()), 0, 8);
		$user->update(['password' => $password]);

		// Отправка письма пользователю
		$content = 'Ваш новый пароль для пользователя <b>' . $user->login . '</b> на&nbsp;сайте ' . config('app.url') . '</a>: <b>' . $password . '</b>';

		Mail::send([
			'html'  => 'chunker.base::mail.notice.html',
			'text'  => 'chunker.base::mail.notice.text'
		], ['content' => $content], function(Message $message) use ($user) {
			$message
				->to($user->email, $user->getName())
				->subject('Новый пароль на сайте ' . config('app.url'));
		});


		// Уведомление
		flash()->success('Новый пароль отправлен на&nbsp;электронный адрес, указанный в&nbsp;настройках учётной записи');


		return redirect()->route('admin.notices');
	}
}