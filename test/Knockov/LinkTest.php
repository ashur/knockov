<?php

/*
 * This file is part of knockov
 */

use PHPUnit\Framework\TestCase;

class LinkTest extends TestCase
{
	/**
	 * Values that can't be registered as strings
	 *
	 * @return	string
	 */
	public function invalidStringProvider()
	{
		return [
			[ false ],
			[ true ],
			[ [] ],
			[ (object)[] ],
			[ -1 ]
		];
	}

	/**
	 * @dataProvider invalidStringProvider
	 * @expectedException InvalidArgumentException
	 */
	public function testSetInvalidString( $string )
	{
		$link = new Knockov\Link( $string );
	}

	/**
	 *
	 */
	public function testGetValue()
	{
		$string = 'hello';
		$link = new Knockov\Link( $string );
		$value = $link->getValue();

		$this->assertEquals( $string, $value );
	}

	/**
	 * Calling getNextLink without registering Links should return false
	 */
	public function testGetNextLinkWithoutRegisteringLinks()
	{
		$link = new Knockov\Link( 'hello' );
		$nextLink = $link->getNextLink();

		$this->assertFalse( $nextLink );
	}

	/**
	 * Calling getNextLink after registering only one Link will always return
	 * that object
	 */
	public function testAddLink()
	{
		$helloLink = new Knockov\Link( 'hello' );

		$worldLink = new Knockov\Link( 'world' );
		$helloLink->addLink( $worldLink );

		$nextLink = $helloLink->getNextLink();

		$this->assertEquals( $worldLink, $nextLink );
	}

	/**
	 * Casting a Link object as a string should return Link::$value
	 */
	public function testToString()
	{
		$string = 'hello';
		$link = new Knockov\Link( $string );

		$this->assertEquals( $string, (string)$link );
	}

	/**
	 * getNextLink should eventually return all registered Link values
	 * given enough iterations
	 */
	public function testMultipleAddLinkCalls()
	{
		$helloLink = new Knockov\Link( 'hello' );

		$linkStrings[] = 'everyone';
		$linkStrings[] = 'stranger';
		$linkStrings[] = 'world';

		foreach( $linkStrings as $linkString )
		{
			$nextLink = new Knockov\Link( $linkString );
			$helloLink->addLink( $nextLink );
		}

		$nextLinkValues = [];

		$iterations = pow( count( $linkStrings ), count( $linkStrings ) );
		for( $i = 0; $i < $iterations; $i++ )
		{
			$nextLink = $helloLink->getNextLink();
			$nextLinkValues[] = $nextLink->getValue();
		}

		$uniqueLinkValues = array_unique( $nextLinkValues );

		sort( $linkStrings );
		sort( $uniqueLinkValues );

		$this->assertEquals( $linkStrings, $uniqueLinkValues );
	}

	/**
	 * When each Link has only one child Link, getChain should always return
	 * a predictable chain
	 */
	public function testNonBranchingGetChain()
	{
		$links[] = new Knockov\Link( 'hello,' );
		$links[] = new Knockov\Link( 'my' );
		$links[] = new Knockov\Link( 'friend.' );

		/* Chain Links together */
		for( $i = count( $links ) - 1; $i >= 1; $i-- )
		{
			$links[$i - 1]->addLink( $links[$i] );
		}

		$linkedChain = $links[0]->getChain();
		foreach( $linkedChain as $link )
		{
			$linkValues[] = $link->getValue();
		}

		$chainString = implode( ' ', $linkValues );
		$this->assertEquals( 'hello, my friend.', $chainString );
	}

	/**
	 *
	 */
	public function testGetNormalizedValue()
	{
		$links[] = new Knockov\Link( 'Hello' );
		$links[] = new Knockov\Link( 'hello' );
		$links[] = new Knockov\Link( 'HELLO' );
		$links[] = new Knockov\Link( ' hello ' );

		foreach( $links as $link )
		{
			$this->assertEquals( 'hello', $link->getNormalizedValue() );
		}
	}

	/**
	 * Reset contents of internal links array
	 */
	public function testClearLinks()
	{
		$helloLink = new Knockov\Link( 'hello' );
		$worldLink = new Knockov\Link( 'world' );

		$helloLink->addLink( $worldLink );
		$this->assertEquals( $worldLink, $helloLink->getNextLink() );

		$helloLink->clearLinks();
		$this->assertEquals( false, $helloLink->getNextLink() );
	}

	/**
	 * By default, a Link should not be a start word
	 */
	public function testIsStartWord()
	{
		$link = new Knockov\Link( 'foo' );
		$this->assertFalse( $link->isStartWord() );

		$link->isStartWord( true );
		$this->assertTrue( $link->isStartWord() );
	}
}
