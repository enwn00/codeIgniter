<?php

namespace App\Dto;

use App\Helper\Traits\ArrayTrait;

class ApiResponse
{
    use ArrayTrait;

    /**
     * @var bool
     */
    private $status;

    /**
     * @var int
     */
    private $code;

    /**
     * @var string
     */
    private $msg;

    /**
     * @var string
     */
    private $msg_detail;

    /**
     * @var array
     */
    private $data;

    /**
     * @param bool $status
     * @return void
     */
    private function setStatus(bool $status): void
    {
        $this->status = $status;
    }

    /**
     * @param int $code
     * @return ApiResponse
     */
    public function setCode(int $code): ApiResponse
    {
        $this->code = $code;
        return $this;
    }

    /**
     * @param string $msg
     * @return ApiResponse
     */
    public function setMsg(string $msg): ApiResponse
    {
        $this->msg = $msg;
        return $this;
    }

    /**
     * @param string $msg_detail
     * @return ApiResponse
     */
    public function setMsgDetail(string $msg_detail): ApiResponse
    {
        $this->msg_detail = $msg_detail;
        return $this;
    }

    /**
     * @param array $data
     * @return ApiResponse
     */
    public function setData(array $data): ApiResponse
    {
        $this->data = $data;
        return $this;
    }

    /**
     * @return string
     */
    public function successResponse(): string
    {
        $this->setStatus(true);
        if (!$this->code){
            $this->setCode(200);
        }

        return json_encode($this->toArray());
    }

    /**
     * @return string
     */
    public function failResponse(): string
    {
        $this->setStatus(false);
        if (!$this->code){
            $this->setCode(500);
        }

        return json_encode($this->toArray());
    }
}
