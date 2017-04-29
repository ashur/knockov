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
		];
	}

	/**
	 * @param		mixed	$depth
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

	// /**
	//  * @param	string	$string
	//  * @dataProvider	validStringProvider
	//  */
	// public function testRegisterString( $string )
	// {
	// 	$knockov = new Knockov\Knockov();
	// 	$knockov->registerString( $string );
	// }
	//
	// /**
	//  * @return	array
	//  */
	// public function validStringProvider()
	// {
	// 	return [
	// 		[ 'I am going' ],
	// 		[ 'we are going' ],
	// 		[ 'you are going' ],
	// 	];
	// }
}
