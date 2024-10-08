<?php

require_once __DIR__ . '/../vendor/autoload.php';

class Markdown
{
    private $parsedown;

    public function __construct()
    {
        $this->parsedown = new \Parsedown();
    }

    public function parse($markdown)
    {
        return $this->parsedown->text($markdown);
    }
}