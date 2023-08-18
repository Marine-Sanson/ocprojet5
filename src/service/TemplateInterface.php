<?php
/**
 * TemplateInterface File Doc Comment
 * 
 * PHP Version 8.1.10
 * 
 * @category Service
 * @package  App\service
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://www.blog.marinesanson.fr/ Not inline for the moment
 */
declare(strict_types=1);

namespace App\service;

 /**
  * TemplateInterface Class Doc Comment
  * This interface ask for a function render with a string for the template 
  * name and an array for parameters
  * 
  * @category Service
  * @package  App\service
  * @author   Marine Sanson <marine_sanson@yahoo.fr>
  * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
  * @link     https://www.blog.marinesanson.fr/ Not inline for the moment
  */
interface TemplateInterface
{
    /**
     * Summary of render
     * This function receive two arguments and return a string
     * 
     * @param string $templateName Name of the template
     * @param array  $parameters   Parameters
     * 
     * @return string template to display
     */
    public function render(string $templateName, array $parameters) :string;
}
