<?php

namespace Carrooi\PdfExtractor;

/**
 *
 * @author David Kudera
 */
class PdfExtractor
{


	/** @var string */
	private $program = 'pdftotext';

	/** @var bool */
	private $available;

	/** @var bool */
	private $preserveLayout = false;


	/**
	 * @return string
	 */
	public function getProgram()
	{
		return $this->program;
	}


	/**
	 * @param string $program
	 * @return $this
	 */
	public function setProgram($program)
	{
		$this->program = $program;
		return $this;
	}


	/**
	 * @return bool
	 */
	public function getPreserverLayout()
	{
		return $this->preserveLayout;
	}


	/**
	 * @param bool $preserveLayout
	 * @return $this
	 */
	public function setPreserveLayout($preserveLayout = true)
	{
		$this->preserveLayout = $preserveLayout;
		return $this;
	}


	/**
	 * @return bool
	 */
	public function isAvailable()
	{
		if ($this->available === null) {
			$command = "which {$this->getProgram()}";
			exec($command, $output, $return);

			if ($return === 0) {
				$this->available = true;
				$this->setProgram($output[0]);
			} else {
				$this->available = false;
			}
		}

		return $this->available;
	}


	/**
	 * @param string $file
	 * @return string
	 */
	public function extractText($file)
	{
		if (!is_file($file) || !is_readable($file)) {
			throw new FileNotFoundException('Could not read file '. $file. '.');
		}

		if (!$this->isAvailable()) {
			throw new ExtractorException('Could not find pdf text extractor '. $this->getProgram(). '.');
		}

		$command = [
			$this->getProgram(),
			'"'. $file. '"',
		];

		if ($this->getPreserverLayout()) {
			$command[] = '-layout';
		}

		$command[] = '-';		// output to stdout
		$command[] = '2>&1';
		$command = implode(' ', $command);

		exec($command, $output, $return);

		if ($return === 0) {
			return implode("\n", $output);
		} else {
			throw new ExtractorException($output[0]);
		}
	}

}
