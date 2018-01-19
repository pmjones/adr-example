<?php
namespace Pmjones\Adr\Domain;

class Payload
{
    /** A creation command succeeded. */
    const STATUS_CREATED = 'CREATED';

    /** A deletion command succeeded. */
    const STATUS_DELETED = 'DELETED';

    /** There was a major error of some sort. */
    const STATUS_ERROR = 'ERROR';

    /** A query successfully returned results. */
    const STATUS_FOUND = 'FOUND';

    /** A new object is being returned. */
    const STATUS_NEW = 'NEW';

    /** A creation command failed. */
    const STATUS_NOT_CREATED = 'NOT_CREATED';

    /** A deletion command failed. */
    const STATUS_NOT_DELETED = 'NOT_DELETED';

    /** A query failed to return results. */
    const STATUS_NOT_FOUND = 'NOT_FOUND';

    /** An update command failed. */
    const STATUS_NOT_UPDATED = 'NOT_UPDATED';

    /** User input was not valid. */
    const STATUS_NOT_VALID = 'NOT_VALID';

    /** An update command succeeded. */
    const STATUS_UPDATED = 'UPDATED';

    /** User input was valid. */
    const STATUS_VALID = 'VALID';

    public function __construct(string $status, array $result = [])
    {
        $this->status = $status;
        $this->result = $result;
    }

    public function getStatus() : string
    {
        return $this->status;
    }

    public function getResult() : array
    {
        return $this->result;
    }
}
