<?php

require_once 'Tabuleiro.php';

require_once 'PHPUnit/Framework/TestCase.php';

/**
 * Tabuleiro test case.
 */
class TabuleiroTest extends PHPUnit_Framework_TestCase {
	
	/**
	 * @var Tabuleiro
	 */
	private $Tabuleiro;
	
	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp() {
		parent::setUp ();
		
		// TODO Auto-generated TabuleiroTest::setUp()
		

		$this->Tabuleiro = new Tabuleiro(/* parameters */);
	
	}
	
	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown() {
		// TODO Auto-generated TabuleiroTest::tearDown()
		

		$this->Tabuleiro = null;
		
		parent::tearDown ();
	}
	
	/**
	 * Constructs the test case.
	 */
	public function __construct() {
		// TODO Auto-generated constructor
	}
	
	/**
	 * Tests Tabuleiro->__toString()
	 */
	public function test__toString() {
		// TODO Auto-generated TabuleiroTest->test__toString()
		$this->markTestIncomplete ( "__toString test not implemented" );
		
		$this->Tabuleiro->__toString(/* parameters */);
	
	}
	
	/**
	 * Tests Tabuleiro->movePeca()
	 */
	public function testMovePeca() {
		// TODO Auto-generated TabuleiroTest->testMovePeca()
		$this->markTestIncomplete ( "movePeca test not implemented" );
		
		$this->Tabuleiro->movePeca(/* parameters */);
	
	}
	
	/**
	 * Tests Tabuleiro->jogaPeca()
	 */
	public function testJogaPeca() {
		// TODO Auto-generated TabuleiroTest->testJogaPeca()
		$this->markTestIncomplete ( "jogaPeca test not implemented" );
		
		$this->Tabuleiro->jogaPeca(/* parameters */);
	
	}
	
	/**
	 * Tests Tabuleiro::getInstance()
	 */
	public function testGetInstance() {
		// TODO Auto-generated TabuleiroTest::testGetInstance()
		$this->markTestIncomplete ( "getInstance test not implemented" );
		
		Tabuleiro::getInstance(/* parameters */);
	
	}

}

