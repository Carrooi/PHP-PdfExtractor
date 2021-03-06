<?php

/**
 * Test: Carrooi\PdfExtractor\PdfExtractor
 *
 * @testCase CarrooiTests\PdfExtractor\PdfExtractorTest
 * @author David Kudera
 */

namespace CarrooiTests\PdfExtractor;

use Carrooi\PdfExtractor\PdfExtractor;
use Tester\Assert;
use Tester\TestCase;

require_once __DIR__ . '/../bootstrap.php';

/**
 *
 * @author David Kudera
 */
class PdfExtractorTest extends TestCase
{


	/** @var \Carrooi\PdfExtractor\PdfExtractor */
	private $extractor;


	public function setUp()
	{
		$this->extractor = new PdfExtractor;
	}


	public function tearDown()
	{
		$this->extractor = null;
	}


	public function testIsAvailable()
	{
		$this->extractor->setProgram('echo');

		Assert::true($this->extractor->isAvailable());
		Assert::notSame('echo', $this->extractor->getProgram());
	}


	public function testIsAvailable_expanded()
	{
		$this->extractor->setProgram('echo');
		$this->extractor->isAvailable();

		$program = $this->extractor->getProgram();

		$extractor = new PdfExtractor;
		$extractor->setProgram($program);

		Assert::true($extractor->isAvailable());
		Assert::same($program, $extractor->getProgram());
	}


	public function testIsAvailable_not()
	{
		$this->extractor->setProgram('someRandomProgramName');

		Assert::false($this->extractor->isAvailable());
	}


	public function testExtractText_extractorNotExists()
	{
		$this->extractor->setProgram('someRandomProgramName');

		Assert::exception(function() {
			$this->extractor->extractText(__DIR__. '/files/simple.pdf');
		}, 'Carrooi\PdfExtractor\ExtractorException', 'Could not find pdf text extractor someRandomProgramName.');
	}


	public function testExtractText_fileNotExists()
	{
		Assert::exception(function() {
			$this->extractor->extractText(__DIR__. '/someRandomProgramName');
		}, 'Carrooi\PdfExtractor\FileNotFoundException', 'Could not read file '. __DIR__. '/someRandomProgramName.');
	}


	public function testExtractText()
	{
		$text = $this->extractor->extractText(__DIR__. '/files/simple.pdf');

		Assert::contains("test", $text);
	}


	public function testExtractText_noLayout()
	{
		$text = $this->extractor->extractText(__DIR__. '/files/layout.pdf');

		Assert::contains("Test", $text);
		Assert::contains("Test2", $text);
	}


	public function testExtractText_withLayout()
	{
		$this->extractor->setPreserveLayout(true);

		$text = $this->extractor->extractText(__DIR__. '/files/layout.pdf');

		Assert::contains("Test   Test2", $text);
	}


	public function testExtractText_notValidFile()
	{
		Assert::exception(function() {
			$this->extractor->extractText(__DIR__. '/files/simple.txt');
		}, 'Carrooi\PdfExtractor\ExtractorException', 'File '. __DIR__. '/files/simple.txt is not valid PDF.');
	}

}


run(new PdfExtractorTest);