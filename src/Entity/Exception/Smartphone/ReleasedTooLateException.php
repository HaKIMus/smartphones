<?php

declare(strict_types=1);

namespace App\Entity\Exception\Smartphone;

use App\Entity\Exception\InvalidArgumentException;

final class ReleasedTooLateException extends InvalidArgumentException  {}