<?php

namespace App\Http\Request;

use App\Helper\Str;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

abstract class AbstractRequest
{
    public function __construct(
        private RequestStack $requestStack,
        private ValidatorInterface $validator
    ) {
        $this->buildRequest();
    }

    /**
     * @return Request|null
     */
    public function getRequest(): ?Request
    {
        return $this->requestStack->getMainRequest();
    }

    /**
     * Validate current request
     * @return ConstraintViolationListInterface
     */
    public function validate(): ConstraintViolationListInterface
    {
        return $this->validator->validate($this, null, $this->groups());
    }

    /**
     * Build request
     * @return void
     */
    protected function buildRequest()
    {
        $request = $this->getRequest();
        $requestParameters = array_merge($request->query->all(), $request->request->all());

        foreach ($requestParameters as $key => $value) {
            $method = 'set' . Str::camelCase($key);

            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }

    /**
     * Define validation groups, override in child class
     * @return string[]
     */
    protected function groups(): array
    {
        return ['Default'];
    }
}
