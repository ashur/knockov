<?php

/*
 * This file is part of Knockov
 */
namespace Knockov;

class Knockov
{
	/**
	 * @var	int
	 */
	protected $depth;

	/**
	 * @param	int		$depth
	 * @return	void
	 */
	public function __construct( $depth )
	{
		$this->depth = $depth;
	}

	/**
	 * @return	int
	 */
	public function getDepth()
	{
		return $this->depth;
	}
}
