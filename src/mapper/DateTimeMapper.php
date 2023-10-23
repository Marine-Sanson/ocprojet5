<?php
/**
 * DateTimeMapper File Doc Comment
 *
 * PHP Version 8.1.10
 *
 * @category Mapper
 * @package  App\mapper
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://www.blog.marinesanson.fr/ Not inline for the moment
 */
declare(strict_types=1);

namespace App\mapper;

use DateTime;

/**
 * DateTimeMapper Class Doc Comment
 *
 * @category Mapper
 * @package  App\mapper
 * @author   Marine Sanson <marine_sanson@yahoo.fr>
 * @license  https://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://www.blog.marinesanson.fr/ Not inline for the moment
 */
class DateTimeMapper
{

    /**
     * Summary of _instance
     *
     * @var DateTimeMapper
     */
    private static $instance;


    /**
     * Summary of getInstance
     * That method create the unique instance of the class, if it doesn't exist and return it
     *
     * @return \App\mapper\DateTimeMapper
     */
    public static function getInstance(): DateTimeMapper
    {

        if (self::$instance === null) {
            self::$instance = new DateTimeMapper();
        }

        return self::$instance;

    }//end getInstance()


    /**
     * Summary of toDateTime
     *
     * @param string $dateString date
     *
     * @return \DateTime
     */
    public function toDateTime(string $dateString): DateTime
    {

        return DateTime::createFromFormat("Y-m-d H:i:s", $dateString);

    }//end toDateTime()


    /**
     * Summary of fromDateTime
     *
     * @param \DateTime $dateTime date
     *
     * @return string
     */
    public function fromDateTime(DateTime $dateTime): string
    {

        return $dateTime->format($dateTime->format("Y-m-d H:i:s"));

    }//end fromDateTime()


    /**
     * Summary of getCurrentDate
     *
     * @return \DateTime
     */
    public function getCurrentDate(): DateTime
    {

        return DateTime::createFromFormat("Y-m-d H:i:s", date("Y-m-d H:i:s"));

    }//end getCurrentDate()


}//end class
