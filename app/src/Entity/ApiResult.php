<?php

namespace App\Entity;

class ApiResult
{
    /*******************************************************************
     * Constructor
     *******************************************************************/
    public function __construct()
    {
        $this->code = 0;
        $this->message = '';
        $this->context = [];
        $this->data = [];
    }

    /*******************************************************************
     * Entity attributes
     *******************************************************************/
    private $code;
    private $message;
    private $context;
    private $data;

    /*******************************************************************
     * Getters and Setters
     *******************************************************************/
    public function getCode(): int
    {
        return $this->code;
    }
    public function setCode(int $code)
    {
        $this->code = $code;
        return $this;
    }

    /********************/
    public function getMessage(): string
    {
        return $this->message;
    }
    public function setMessage(string $message)
    {
        $this->message = $message;
        return $this;
    }

    /********************/
    public function getContext()
    {
        return $this->context;
    }
    public function setContext($context)
    {
        $this->context = $context;
        return $this;
    }

    /********************/
    public function getData()
    {
        return $this->data;
    }
    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }
}