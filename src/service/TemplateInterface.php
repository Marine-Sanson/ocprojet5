<?php
declare(strict_types=1);

namespace App\service;

interface TemplateInterface
{
    public function render(string $templateName, array $parameters) :string;
}
