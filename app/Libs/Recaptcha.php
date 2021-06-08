<?php

namespace Chunker\Base\Libs;


use Illuminate\Http\Request;

class Recaptcha
{
	public static function check(Request $request) {
		$url = 'https://www.google.com/recaptcha/api/siteverify';
		$params = [
			'secret'   => env('RECAPTCHA_SECRETKEY'),
			'response' => $request->input('g-recaptcha-response') ?: $request->input('gRecaptchaResponse'),
			'remoteip' => $request->getClientIp(),
		];

		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		$response = curl_exec($ch);
		if (!empty($response)) {
			$decoded_response = json_decode($response);
		}

		if ($decoded_response->success ?? false) {
			return $decoded_response->success;
		}

		return false;
	}


	public static function getInput() {
		return '<div class="g-recaptcha" data-sitekey="' . env('RECAPTCHA_SITEKEY') . '"></div>';
	}


	public static function getJsScript() {
		return '<script src="https://www.google.com/recaptcha/api.js"></script>';
	}
}