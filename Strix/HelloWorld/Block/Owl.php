<?php

declare(strict_types=1);

namespace Strix\HelloWorld\Block;

use Magento\Framework\View\Element\Template;

class Owl extends Template
{
    /**
     * @return int
     */
    public function foo(): int
    {
        return 42;
    }
}