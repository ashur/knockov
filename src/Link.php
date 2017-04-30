<?php

/*
 * This file is part of Knockov
 */
namespace Knockov;

class Link
{
	/**
	 * @var	array
	 */
	protected $links=[];

	/**
	 * @var	string
	 */
	protected $value;

	/**
	 * @param	string	$value
	 * @return	void
	 */
	public function __construct( $value )
	{
		if( !is_string( $value ) )
		{
			$valueString = var_export( $value, true );
			throw new \InvalidArgumentException( "Invalid value '{$valueString}', string expected" );
		}

		$this->value = $value;
	}

	/**
	 * @return	string
	 */
	public function __toString()
	{
		return $this->value;
	}

	/**
	 * @param	Knockov\Link	$link
	 * @return	void
	 */
	public function addLink( Link $link )
	{
		$this->links[] = $link;
	}

	/**
	 * Reset contents of internal links array
	 *
	 * @return	void
	 */
	public function clearLinks()
	{
		$this->links = [];
	}

	/**
	 * Return array of Knockov\Link objects originating from this Link
	 *
	 * @return	array
	 */
	public function getChain()
	{
		$chain[] = $this;

		$nextLink = $this->getNextLink();
		if( $nextLink == false )
		{
			return $chain;
		}

		$chain = array_merge( $chain, $nextLink->getChain() );
		return $chain;
	}

	/**
	 * Return a random link based on the probability of occurrence
	 *
	 * @return	Knockov\Link
	 */
	public function getNextLink()
	{
		if( count( $this->links ) == 0 )
		{
			return false;
		}

		$index = array_rand( $this->links );
		$nextLink = $this->links[$index];

		return $nextLink;
	}

	/**
	 * @return	string
	 */
	public function getNormalizedValue()
	{
		$normalizedValue = $this->value;
		$normalizedValue = strtolower( $normalizedValue );
		$normalizedValue = trim( $normalizedValue );

		return $normalizedValue;
	}

	/**
	 * @return	string
	 */
	public function getValue()
	{
		return $this->value;
	}
}
