<?php

namespace Chunker\Base\Models\Observers;

use Chunker\Base\Models\Notice;
use Chunker\Base\Models\User;
use Illuminate\Mail\Message;
use Mail;

class NoticeObserver
{
	public function created(Notice $notice) {
		/*
		 * При создании уведомления его содержимое отправляется на почту подписанным пользователям
		 */
		Mail::send(
			[
				'html' => 'chunker.base::mail.notice.html',
				'text' => 'chunker.base::mail.notice.text'
			],
			[ 'content' => $notice->content ],
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