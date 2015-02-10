<?php

namespace Carrooi\PdfExtractor;

class RuntimeException extends \RuntimeException {}

class InvalidArgumentException extends \InvalidArgumentException {}

class InvalidStateException extends RuntimeException {}

class IOException extends RuntimeException {}

class FileNotFoundException extends IOException {}

class ExtractorException extends RuntimeException {}
