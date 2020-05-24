<?php

/**
 * Class IdWorker snowflake算法生成unique id
 * @package Snowflake
 */
class Snowflake
{
    //开始时间
    const EPOCH_OFFSET = 1293811200000;
    //首位
    const SIGN_BITS = 1;
    //时间戳相减占用的位数
    const TIMESTAMP_BITS = 41;
    //数据中心位数
    const DATA_CENTER_BITS = 5;
    //机器位数
    const MACHINE_ID_BITS = 5;
    //同一毫秒内自增的位数
    const SEQUENCE_BITS = 12;

    /**
     * @var IdWorker
     */
    private static $idWorker;
    /**
     * @var mixed
     */
    protected $dataCenterId;

    /**
     * @var mixed
     */
    protected $machineId;

    /**
     * @var null|int
     */
    protected $lastTimestamp = null;


    /**
     * @var int
     */
    protected $sequence = 1;


    protected $signLeftShift = self::TIMESTAMP_BITS + self::DATA_CENTER_BITS + self::MACHINE_ID_BITS + self::SEQUENCE_BITS;
    protected $timestampLeftShift = self::DATA_CENTER_BITS + self::MACHINE_ID_BITS + self::SEQUENCE_BITS;
    protected $dataCenterLeftShift = self::MACHINE_ID_BITS + self::SEQUENCE_BITS;
    protected $machineLeftShift = self::SEQUENCE_BITS;
    //最大自增数
    //下边语法执行效果 等于 (1 << 12) - 1;
    protected $maxSequenceId   = ~ (-1 << self::SEQUENCE_BITS);
    //最大机器数
    protected $maxMachineId    = ~ (-1 << self::MACHINE_ID_BITS);
    //最大数据中心机器数
    protected $maxDataCenterId = ~ (-1 << self::DATA_CENTER_BITS);

    /**
     * IdWorker constructor.
     * @param $dataCenter_id
     * @param $machine_id
     * @throws Exception
     */
    public function __construct($dataCenter_id, $machine_id)
    {
        if ($dataCenter_id > $this->maxDataCenterId) {
            throw new \Exception('data center id should between 0 and ' . $this->maxDataCenterId);
        }
        if ($machine_id > $this->maxMachineId) {
            throw new \Exception('machine id should between 0 and ' . $this->maxMachineId);
        }
        $this->dataCenterId = $dataCenter_id;
        $this->machineId = $machine_id;
    }

    /**
     * @return string
     * @throws Exception
     */
    public function id()
    {
        $sign = 0;
        $timestamp = $this->getUnixTimestamp();
        if ($timestamp < $this->lastTimestamp) {
            throw new \Exception('Clock moved backwards!');
        }
        if ($this->lastTimestamp == $timestamp) {
            $this->sequence++;
            if ($this->sequence > $this->maxSequenceId) {
               return $this->id();
            }
        } else {
            $this->sequence = 1;
        }
        $this->lastTimestamp = $timestamp;
        //算出时间差值
        $time = (int)($timestamp - self::EPOCH_OFFSET);

        //($sign << $this->signLeftShift) =》  1 左移 63 位 : 1000000000000000000000000000000000000000000000000000000000000000
        //($time << $this->timestampLeftShift) 时间左移 22 位
        // ($this->dataCenterId << $this->dataCenterLeftShift) 数据中心 左移 17位
        // ($this->machineId << $this->machineLeftShift) 机器中心左移 12 位
        $id = ($sign << $this->signLeftShift) | ($time << $this->timestampLeftShift) | ($this->dataCenterId << $this->dataCenterLeftShift) | ($this->machineId << $this->machineLeftShift) | $this->sequence;
        return (string)$id;
    }

    /**
     * Notes:parse
     * @author  zhangrongwang
     * @date 2018-12-25 16:41:27
     * @param $uuid
     * @return array
     */
    public function parse($uuid)
    {
        //转化为二进制字符串
        $binUuid = decbin($uuid);
        $len = strlen($binUuid);
        $sequenceStart = $len - self::SEQUENCE_BITS;
        //截取自增的二进制字符串
        $sequence = substr($binUuid, $sequenceStart, self::SEQUENCE_BITS);

        $machineIdStart = $len - self::MACHINE_ID_BITS - self::SEQUENCE_BITS;
        $machineId = substr($binUuid, $machineIdStart, self::MACHINE_ID_BITS);

        $dataCenterIdStart = $len - self::DATA_CENTER_BITS - self::MACHINE_ID_BITS - self::SEQUENCE_BITS;
        $dataCenterId = substr($binUuid, $dataCenterIdStart, self::DATA_CENTER_BITS);

        $timestamp = substr($binUuid, 0, $dataCenterIdStart);
        $realTimestamp = bindec($timestamp) + self::EPOCH_OFFSET;
        $timestamp = substr($realTimestamp, 0, -3);
        $microSecond = substr($realTimestamp, -3);
        return [
            'timestamp' => date('Y-m-d H:i:s', $timestamp) . '.' . $microSecond,
            'dataCenterId' => bindec($dataCenterId),
            'machineId' => bindec($machineId),
            'sequence' => bindec($sequence),
        ];
    }

    /**
     * Notes:getUnixTimestamp
     * @author  zhangrongwang
     * @date 2018-12-25 11:42:06
     */
    private function getUnixTimestamp()
    {
        return floor(microtime(true) * 1000);
    }
}