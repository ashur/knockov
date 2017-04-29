<?php

/*
 * This file is part of knockov
 */

use PHPUnit\Framework\TestCase;

class KnockovTest extends TestCase
{
	/**
	 * @return	array
	 */
	public function invalidDepthProvider()
	{
		return [
			[ 'hello' ],
			[ false ],
			[ true ],
			[ [] ],
			[ (object)[] ],
			[ -1 ]
		];
	}

	/**
	 * @dataProvider		invalidDepthProvider
	 * @expectedException	InvalidArgumentException
	 */
	public function testSetInvalidDepth( $depth )
	{
		$knockov = new Knockov\Knockov( $depth );
	}

	/**
	 *
	 */
	public function testGetDepth()
	{
		$depth = 1;
		$knockov = new Knockov\Knockov( $depth );
		$this->assertEquals( $depth, $knockov->getDepth() );
	}
}
