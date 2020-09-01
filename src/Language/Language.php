<?php

namespace OrganizationalChart\Language;

final class Language
{
	/** @var string */
	private $language;

	/**
	 * @param string $language
	 */
	public function __construct(?string $language)
	{
		if (empty($language) || !in_array($language, ['english', 'italian'])) {
			throw new \InvalidArgumentException("language is required to be either 'english' or 'italian'");
		}

		$this->language = $language;
	}

	public function __toString()
	{
		return $this->language;
	}
}
