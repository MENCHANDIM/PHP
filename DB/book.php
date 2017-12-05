<?php
/**
 * Created by PhpStorm.
 * User: CHANDIM
 * Date: 12/3/2017
 * Time: 11:58
 */

class book
{
    private $title;
    private $author;
    private $rate;
    private $comment;
    private $status;

    /**
     * @return null
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param null $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return null
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param null $author
     */
    public function setAuthor($author)
    {
        $this->author = $author;
    }

    /**
     * @return null
     */
    public function getRate()
    {
        return $this->rate;
    }

    /**
     * @param null $rate
     */
    public function setRate($rate)
    {
        $this->rate = $rate;
    }

    /**
     * @return null
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @param null $comment
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
    }

    /**
     * @return null
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param null $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    function __construct() {
        $this->title = isset($_POST['title']) ? $_POST['title'] : null;
        $this->author = isset($_POST['author']) ? $_POST['author'] : null;
        $this->rate = isset($_POST['rate']) ? $_POST['rate'] : null;
        $this->comment = isset($_POST['comment']) ? $_POST['comment'] : null;
        $this->status = isset($_POST['status']) ? $_POST['status'] : null;
    }
//    function __construct($title,$author,$rate,$comment,$status) {
//        $this->title = $title;
//        $this->author = $author;
//        $this->rate = $rate;
//        $this->comment = $comment;
//        $this->status = $status;
//    }

    public function info(){
        var_dump(get_object_vars($this));
    }
}