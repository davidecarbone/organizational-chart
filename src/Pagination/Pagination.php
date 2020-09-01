<?php

namespace OrganizationalChart\Pagination;

final class Pagination
{
	/** @var int */
	private $pageNumber;

	/** @var int */
	private $pageSize;

	/**
	 * @param int $pageNumber
	 * @param int $pageSize
	 */
	public function __construct($pageNumber, $pageSize)
	{
		if (!preg_match('/^[0-9]+$/', $pageNumber)) {
			throw new \InvalidArgumentException("page_num must be an integer >= 0");
		}

		if (!preg_match('/^(0|[1-9][0-9]{0,2}|1000)$/', $pageSize)) {
			throw new \InvalidArgumentException("page_size must be an integer between 0 and 1000");
		}

		$this->pageNumber = $pageNumber;
		$this->pageSize = $pageSize;
	}

	/**
	 * @return int
	 */
	public function pageSize(): int
	{
		return $this->pageSize;
	}

	/**
	 * @return int
	 */
	public function offset(): int
	{
		return $this->pageNumber * $this->pageSize;
	}
}
