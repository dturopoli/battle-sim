<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Validator\ConstraintViolation;

abstract class BaseController extends AbstractController
{
    /**
     * @param ConstraintViolation[] $violations
     * @return array
     */
    public function formatViolations(array $violations): array
    {
        $errors = [];

        foreach ($violations as $violation) {
            $errors[] = sprintf(
                'Invalid argument %s: %s',
                $violation->getPropertyPath(),
                $violation->getMessage(),
            );
        }

        return $errors;
    }
}
