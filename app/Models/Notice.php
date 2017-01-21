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


	public static function boot() {

		/**
		 * При создании уведомления его содержимое отправляется на почту подписанным пользователям
		 */
		static::created(function($instance) {
			Mail::send(
				[
					'html' => 'base::mail.notice.html',
					'text' => 'base::mail.notice.text'
				],
				[ 'content' => $instance->content ],
				function(Message $mail) use ($instance) {
					$users = User::where('is_subscribed', true);

					// Фильтрация по ролям, подписанным на уведомления определенного типа
					$type = $instance->type;

					if ($type) {
						$users->whereHas('roles', function(Builder $query) use ($type) {
							$query->whereIn('base_roles.id', $type->roles()->pluck('id'));
						});
					}

					// Отправка всем подписанным пользователям
					$users
						->get(['id', 'name', 'email' ])
						->each(function($user) use ($mail, $instance) {
							/** Прикрепление уведомления к пользователю */
							$instance->users()->attach($user->id);
							/** Отправка письма */
							$mail->to($user->email, $user->getName());
						});

					// Тема
					$mail->subject('Уведомление с сайта ' . host());
				});
		});

		static::deleted(function($instance){
			$instance->users()->detach();
		});

		parent::boot();
	}
}