<?php

namespace Xsolve\UnitSkelgenBundle\Utils;

class NameTools
{
    /**
     * @var PathTools $pathTools
     */
    protected $pathTools;

    protected $rootDir;
    protected $sourceDir;

    public function __construct(PathTools $pathTools, $rootDir)
    {
        $this->pathTools = $pathTools;
        $this->rootDir = $this->pathTools->normalize($rootDir);
        $this->sourceDir = $this->pathTools->normalize($rootDir . '/../src/');
    }

    public function getRootDir()
    {
        return $this->rootDir;
    }

    public function getSourceDir()
    {
        return $this->sourceDir;
    }

    public function createQualifiedClassName($filename)
    {
        $filenameWithoutExt = preg_replace('/\.php$/', '', $filename);
        $filenameWithoutSrc = str_replace($this->getSourceDir(), '', $filenameWithoutExt);
        $taintedClassName = str_replace('/', '\\', $filenameWithoutSrc);
        $className = preg_replace('/\\+/', '\\', $taintedClassName);

        return preg_replace('/^\\\/', '', $className);
    }

    public function createTestFilename($filename)
    {
        $lastMatch = $this->findLastMatch('/\/[^\/]+Bundle\//', $filename);
        $replacement =  $lastMatch['text'] . 'Tests/';
        $filenameWithTests = $this->replaceLastMatch($lastMatch, $filename, $replacement);

        return preg_replace('/\.php$/i', 'Test.php', $filenameWithTests);
    }

    public function createProductionClassFilename($filename)
    {
        $lastMatch = $this->findLastMatch('/\/Tests\//', $filename);
        $filenameWithoutTests = $this->replaceLastMatch($lastMatch, $filename, '/');

        return preg_replace('/Test\.php$/i', '.php', $filenameWithoutTests);
    }

    protected function findLastMatch($re, $filename)
    {
        $matches = array();
        preg_match_all($re, $filename, $matches, PREG_OFFSET_CAPTURE);
        $lastMatch = end($matches[0]);

        return array(
            'text' => $lastMatch[0],
            'pos' => $lastMatch[1]
        );
    }

    protected function replaceLastMatch($lastMatch, $filename, $replacement)
    {
        return substr($filename, 0, $lastMatch['pos'])
            . $replacement
            . substr($filename, $lastMatch['pos'] + strlen($lastMatch['text']));
    }
}
