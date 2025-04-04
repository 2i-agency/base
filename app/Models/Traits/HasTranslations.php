<?php

namespace Chunker\Base\Models\Traits;

use Chunker\Base\Events\TranslationHasBeenSet;
use Chunker\Base\Exceptions\AttributeIsNotTranslatable;
use Illuminate\Support\Str;


trait HasTranslations
{

	/**
	 * @param string $key
	 *
	 * @return mixed
	 */
	public function getAttributeValue($key) {
		if (!$this->isTranslatableAttribute($key)) {
			return parent::getAttributeValue($key);
		}

		return $this->getTranslation($key, config('app.locale'));
	}


	/**
	 * Set a given attribute on the model.
	 *
	 * @param string $key
	 * @param mixed  $value
	 *
	 * @return $this
	 */
	public function setAttribute($key, $value) {
		// pass arrays and untranslatable attributes to the parent method
		if (!$this->isTranslatableAttribute($key) || is_array($value)) {
			return parent::setAttribute($key, $value);
		}
		// if the attribute is translatable and not already translated (=array),
		// set a translation for the current app locale
		return $this->setTranslation($key, config('app.locale'), $value);
	}


	/**
	 * @param string $key
	 * @param string $locale
	 *
	 * @return mixed
	 */
	public function translate(string $key, string $locale = '') {
		return $this->getTranslation($key, $locale);
	}


	/***
	 * @param string $key
	 * @param string $locale
	 * @param bool   $useFallbackLocale
	 *
	 * @return mixed
	 */
	public function getTranslation(string $key, string $locale) {
		$locale = $this->normalizeLocale($key, $locale);
		$translations = $this->getTranslations($key);
		$translation = $translations[ $locale ] ?? '';
		if ($this->hasGetMutator($key)) {
			return $this->mutateAttribute($key, $translation);
		}

		return $translation;
	}


	public function getTranslations($key):array {
		$this->guardAgainstUntranslatableAttribute($key);

		return json_decode($this->getAttributes()[ $key ] ?? '' ?: '{}', true);
	}


	/**
	 * @param string $key
	 * @param string $locale
	 * @param        $value
	 *
	 * @return $this
	 */
	public function setTranslation(string $key, string $locale, $value) {
		$this->guardAgainstUntranslatableAttribute($key);
		$translations = $this->getTranslations($key);
		$oldValue = $translations[ $locale ] ?? '';
		if ($this->hasSetMutator($key)) {
			$method = 'set' . Str::studly($key) . 'Attribute';
			$value = $this->{$method}($value);
		}
		$translations[ $locale ] = $value;
		$this->attributes[ $key ] = $this->asJson($translations);
		event(new TranslationHasBeenSet($this, $key, $locale, $oldValue, $value));

		return $this;
	}


	/**
	 * @param string $key
	 * @param array  $translations
	 *
	 * @return $this
	 */
	public function setTranslations(string $key, array $translations) {
		$this->guardAgainstUntranslatableAttribute($key);
		foreach ($translations as $locale => $translation) {
			$this->setTranslation($key, $locale, $translation);
		}

		return $this;
	}


	/**
	 * @param string $key
	 * @param string $locale
	 *
	 * @return $this
	 */
	public function forgetTranslation(string $key, string $locale) {
		$translations = $this->getTranslations($key);
		unset($translations[ $locale ]);
		$this->setAttribute($key, $translations);

		return $this;
	}


	public function forgetAllTranslations(string $locale) {
		collect($this->getTranslatableAttributes())->each(function(string $attribute) use ($locale) {
			$this->forgetTranslation($attribute, $locale);
		});
	}


	public function getTranslatedLocales(string $key):array {
		return array_keys($this->getTranslations($key));
	}


	public function isTranslatableAttribute(string $key):bool {
		return in_array($key, $this->getTranslatableAttributes());
	}


	protected function guardAgainstUntranslatableAttribute(string $key) {
		if (!$this->isTranslatableAttribute($key)) {
			throw AttributeIsNotTranslatable::make($key, $this);
		}
	}


	protected function normalizeLocale(string $key, string $locale):string {
		if (in_array($locale, $this->getTranslatedLocales($key))) {
			return $locale;
		}

		return $locale;
	}


	public function getTranslatableAttributes():array {
		return is_array($this->translatable)
			? $this->translatable
			: [];
	}


	public function getCasts():array {
		return array_merge(
			parent::getCasts(),
			array_fill_keys($this->getTranslatableAttributes(), 'array')
		);
	}

}