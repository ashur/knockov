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
		if( !is_int( $depth ) )
		{
			$depthString = var_export( $depth, true );
			throw new \InvalidArgumentException( "Invalid depth '{$depthString}'" );
		}
		if( $depth <= 0 )
		{
			throw new \InvalidArgumentException( "Invalid depth '{$depth}'" );
		}

		$this->depth = $depth;
	}

	/**
	 * @return	int
	 */
	public function getDepth()
	{
		return $this->depth;
	}

	/**
	 * @param	string	$string
	 * @return	void
	 */
	public function registerString( $string )
	{
		if( !is_string( $string ) )
		{
			$stringString = var_export( $string, true );
			throw new \InvalidArgumentException( "Invalid string '{$stringString}'" );
		}
	}
}
