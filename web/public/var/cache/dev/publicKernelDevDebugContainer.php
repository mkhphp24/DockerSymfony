<?php

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.

if (\class_exists(\ContainerFg2MZUx\publicKernelDevDebugContainer::class, false)) {
    // no-op
} elseif (!include __DIR__.'/ContainerFg2MZUx/publicKernelDevDebugContainer.php') {
    touch(__DIR__.'/ContainerFg2MZUx.legacy');

    return;
}

if (!\class_exists(publicKernelDevDebugContainer::class, false)) {
    \class_alias(\ContainerFg2MZUx\publicKernelDevDebugContainer::class, publicKernelDevDebugContainer::class, false);
}

return new \ContainerFg2MZUx\publicKernelDevDebugContainer([
    'container.build_hash' => 'Fg2MZUx',
    'container.build_id' => '68562f04',
    'container.build_time' => 1578947766,
], __DIR__.\DIRECTORY_SEPARATOR.'ContainerFg2MZUx');