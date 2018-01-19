<?php
namespace Pmjones\Adr\Domain;

use Pmjones\Adr\Domain\Payload;
use Exception;

class ApplicationService
{
    public function __call(string $method, array $params)
    {
        try {
            return $this->$method(...$params);
        } catch (Exception $e) {
            return $this->newPayload(Payload::STATUS_ERROR, [
                'method' => $method,
                'params' => $params,
                'exception' => $e,
            ]);
        }
    }

    protected function newPayload(string $status, array $result = []) : Payload
    {
        return new Payload($status, $result);
    }
}
