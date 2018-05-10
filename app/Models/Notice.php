<?php

namespace Chunker\Base\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Mail\Message;
use Mail;

/**
 * Модель уведомлений
 *
 * @package Chunker\Base\Commands
 */
class Notice extends Model
{
	/** @var string название таблицы */
	protected $table = 'base_notices';

	/** @var array поля для массового присвоения атрибутов */
	protected $fillable = [
		'content',
		'is_read',
		'type_id'
	];

	public $users_ids;


	/**
	 * Связь с типом уведомлений
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function type() {
		return $this->belongsTo(NoticesType::class, 'type_id');
	}


	/**
	 * Связь с пользователями
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function users() {
		return $this->belongsToMany(User::class, 'base_notices_users');
	}

	protected function getSubscribeUsers($users_ids = NULL) {
		$notice_type = $this->type;

		if (is_null($notice_type)) {
			return User
				::where('is_subscribed', 1)
				->when(isset($users_ids) && count($users_ids), function($query) use ($users_ids) {
					return $query->whereIn('id', $users_ids);
				})
				->get(['id', 'name', 'emails' ]);
		} else {
			$users = $notice_type
				->users()
				->when(isset($users_ids) && count($users_ids), function($query) use ($users_ids) {
					return $query->whereIn('id', $users_ids);
				})
				->get(['id', 'name', 'emails' ]);

			foreach ($notice_type->roles()->get() as $role) {
				$_users = $role
					->users()
					->when(isset($users_ids) && count($users_ids), function($query) use ($users_ids) {
						return $query->whereIn('id', $users_ids);
					})
					->where('is_subscribed', 1)
					->get(['id', 'name', 'emails' ]);

				foreach ($_users as $user) {
					$users->push($user);
				}
			}

			return $users->unique();
		}
	}


	public static function boot() {

		static::creating(function($instance) {
			return (bool)$instance->getSubscribeUsers($instance->users_ids && count($instance->users_ids) ? $instance->users_ids : NULL)->count();
		});

		/**
		 * При создании уведомления его содержимое отправляется на почту подписанным пользователям
		 */
		static::created(function($instance) {
			$users = $instance->getSubscribeUsers($instance->users_ids && count($instance->users_ids) ? $instance->users_ids : NULL);

			$users->each(function($user) use ($instance) {

				/** Прикрепление уведомления к пользователю */
				$instance->users()->attach($user->id);

				Mail::queue(
					[
						'html' => 'base::mail.notice.html',
						'text' => 'base::mail.notice.text'
					],
					[ 'content' => $instance->content ],
					function(Message $mail) use ($user, $instance) {
						foreach ($user->emails as $email) {
							/** Отправка письма */
							$mail
								->to($email, $user->getName())
								->subject('Уведомление с сайта ' . host());
						}
					});
			});
		});

		static::deleted(function($instance){
			$instance->users()->detach();
		});

		parent::boot();
	}
}