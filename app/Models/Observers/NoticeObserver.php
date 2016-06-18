<?php

namespace Chunker\Base\Models\Observers;

use Chunker\Base\Models\User;
use Illuminate\Mail\Message;
use Mail;

class NoticeObserver
{
	public function created($model) {
		/*
		 * При создании уведомления его содержимое отправляется на почту подписанным пользователям
		 */
		Mail::send(
			[
				'html' => 'chunker.base::mail.notice.html',
				'text' => 'chunker.base::mail.notice.text'
			],
			['content' => $model->content],
			function(Message $mail) {
				// Отправка всем подписанным пользователям
				User
					::where('is_subscribed', true)
					->get(['name', 'email'])
					->each(function($user) use($mail) {
						$mail->to($user->email, $user->getName());
					});

				// Тема
				$mail->subject('Оповещение с сайта ' . host());
			});
	}
}