<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Validator\ConstraintViolationListInterface;

abstract class BaseController extends AbstractController
{
    /**
     * @param ConstraintViolationListInterface $violations
     * @return string[]
     */
    public function formatConstraintViolations(ConstraintViolationListInterface $violations): array
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
