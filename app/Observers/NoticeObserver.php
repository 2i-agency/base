<?php
namespace Chunker\Base\Observers;

use Chunker\Base\Models\Notice;
use Illuminate\Mail\Message;
use Mail;


class NoticeObserver {

		public function creating(Notice $notice) {
			return (bool)$notice->getSubscribeUsers($notice->users_ids && count($notice->users_ids) ? $notice->users_ids : NULL)->count();
		}


		public function created(Notice $notice) {
			$users = $notice->getSubscribeUsers($notice->users_ids && count($notice->users_ids) ? $notice->users_ids : NULL);

			$users->each(function($user) use ($notice) {

				/** Прикрепление уведомления к пользователю */
				$notice->users()->attach($user->id);

				Mail::queue(
					[
						'html' => 'base::mail.notice.html',
						'text' => 'base::mail.notice.text'
					],
					[ 'content' => $notice->content ],
					function(Message $mail) use ($user, $notice) {
						foreach ($user->emails as $email) {
							/** Отправка письма */
							$mail
								->to($email, $user->getName())
								->subject(setting('mail_author') ?: config('mail.from.name'));
						}
					});
			});
		}

		public function deleted(Notice $notice) {
			$notice->users()->detach();
		}
}