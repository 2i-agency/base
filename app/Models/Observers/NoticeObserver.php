<?php

namespace Chunker\Base\Models\Observers;

use Chunker\Base\Models\Notice;
use Chunker\Base\Models\User;
use Illuminate\Database\Eloquent\Builder;
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
			function(Message $mail) use($notice) {
				$users = User::where('is_subscribed', true);

				// Фильтрация по ролям, подписанным на уведомления определенного типа
				$type = $notice->type;

				if ($type) {
					$users->whereHas('roles', function(Builder $query) use($type) {
						$query->whereIn('base_roles.id', $type->roles()->pluck('id'));
					});
				}

				// Отправка всем подписанным пользователям
				$users
					->get(['name', 'email'])
					->each(function($user) use($mail) {
						$mail->to($user->email, $user->getName());
					});

				// Тема
				$mail->subject('Уведомление с сайта ' . host());
			});
	}
}