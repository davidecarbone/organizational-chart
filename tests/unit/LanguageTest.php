<?php

namespace OrganizationalChart\Tests\Unit;

use OrganizationalChart\Language\Language;
use PHPUnit\Framework\TestCase;

class LanguageTest extends TestCase
{
	/**
	 * @test
	 * @dataProvider badLanguages
	 */
	public function can_only_be_built_if_language_is_italian_or_english($language)
	{
		$this->expectException(\InvalidArgumentException::class);

		new Language($language);
	}

	public function badLanguages()
	{
		return [
			['french'],
			['it'],
			[null],
			['']
		];
	}

}
