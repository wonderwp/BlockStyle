<?php

namespace WonderWp\Component\BlockStyle\Response;

use WonderWp\Component\Response\AbstractResponse;
use WP_Block_Type;

class BlockStyleRegistrationResponse extends AbstractResponse implements BlockStyleRegistrationResponseInterface
{
    protected ?WP_Block_Type $wpRegistrationResult = null;

    public function getWpRegistrationResult(): ?WP_Block_Type
    {
        return $this->wpRegistrationResult;
    }

    public function setWpRegistrationResult(?WP_Block_Type $wpRegistrationResult): void
    {
        $this->wpRegistrationResult = $wpRegistrationResult;
    }
}
