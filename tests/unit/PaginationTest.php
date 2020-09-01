<?php

namespace OrganizationalChart\Tests\Unit;

use OrganizationalChart\Pagination\Pagination;
use PHPUnit\Framework\TestCase;

class PaginationTest extends TestCase
{
	/**
	 * @test
	 * @dataProvider badPageNumbers
	 */
	public function can_only_be_built_if_page_number_is_zero_based_integer($pageNumber)
	{
		$this->expectException(\InvalidArgumentException::class);

		new Pagination($pageNumber, 1);
	}

	public function badPageNumbers()
	{
		return [
			[null],
			[''],
			[-1],
			['test'],
			[1.1]
		];
	}

	/**
	 * @test
	 * @dataProvider badPageSizes
	 */
	public function can_only_be_built_if_page_size_is_integer_and_between_zero_and_1000($pageSize)
	{
		$this->expectException(\InvalidArgumentException::class);

		new Pagination(1, $pageSize);
	}

	public function badPageSizes()
	{
		return [
			[null],
			[''],
			[-1],
			['test'],
			[1.1],
			[1001]
		];
	}
}
