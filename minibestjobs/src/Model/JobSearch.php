<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 8/7/18
 * Time: 2:45 PM
 */

namespace App\Model;

class JobSearch
{
    private $keyword;
    /**
     * @return mixed
     */
    public function getKeyword()
    {
        return $this->keyword;
    }
    /**
     * @param mixed $keyword
     */
    public function setKeyword($keyword): void
    {
        $this->keyword = $keyword;
    }
}