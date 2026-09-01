<?php

namespace App\EventListener;

use App\Entity\Photo;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Doctrine\ORM\Event\OnFlushEventArgs;
use Doctrine\ORM\Events;

/**
 * Only one Photo may be used as the "A propos" section portrait at a time.
 * When a Photo is saved with estPortrait = true, unset the flag on every
 * other Photo that currently carries it, within the same flush.
 */
#[AsDoctrineListener(event: Events::onFlush)]
class PhotoPortraitListener
{
    public function onFlush(OnFlushEventArgs $args): void
    {
        $em = $args->getObjectManager();
        $uow = $em->getUnitOfWork();

        $newPortraits = array_filter(
            [...$uow->getScheduledEntityInsertions(), ...$uow->getScheduledEntityUpdates()],
            static fn (object $entity): bool => $entity instanceof Photo && $entity->isEstPortrait(),
        );

        if ([] === $newPortraits) {
            return;
        }

        $classMetadata = $em->getClassMetadata(Photo::class);
        $others = $em->getRepository(Photo::class)
            ->createQueryBuilder('p')
            ->andWhere('p.estPortrait = true')
            ->getQuery()
            ->getResult();

        foreach ($others as $other) {
            if (\in_array($other, $newPortraits, true)) {
                continue;
            }

            $other->setEstPortrait(false);
            $uow->recomputeSingleEntityChangeSet($classMetadata, $other);
        }
    }
}
