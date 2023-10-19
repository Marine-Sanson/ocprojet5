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
     * Summary of display
     *
     * @param string $templateName name of the template
     * @param array  $parameters   parameters
     *
     * @return void
     */
    public function display(string $templateName, array $parameters): void;
    
}//end interface
