<?php

declare(strict_types=1);

namespace App\Listeners;

use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Doctrine\ORM\Event\PreFlushEventArgs;
use Symfony\Component\Config\Definition\Exception\ForbiddenOverwriteException;

#[AsDoctrineListener('preFlush')]
final class PreFlushListener
{
    /**
     *
     * @param private|bool $blockWrite
     */
    public function __construct(
        private bool $blockWrite
    ) {
    }

    /**
     *
     * @param PreFlushEventArgs $args
     * @return void
     */
    public function preFlush(PreFlushEventArgs $args): void
    {
        if ($this->blockWrite) {
            throw new ForbiddenOverwriteException();
        }
    }
}
