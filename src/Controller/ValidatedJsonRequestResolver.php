<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final readonly class ValidatedJsonRequestResolver implements ValueResolverInterface
{
    public function __construct(
        private SerializerInterface $serializer,
        private ValidatorInterface $validator,
    ) {
    }

    /** @return iterable<mixed> */
    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        $type = $argument->getType()
            ?? throw new \RuntimeException('Missing argument type');

        $content = $request->getContent();

        if (empty($content)) {
            throw new BadRequestHttpException('Empty request body');
        }

        $dto = $this->serializer->deserialize($content, $type, 'json');

        $errors = $this->validator->validate($dto);

        if (count($errors) > 0) {
            $errorMessages = [];
            foreach ($errors as $violation) {
                $errorMessages[$violation->getPropertyPath()] = $violation->getMessage();
            }

            $errorMessagesJson = $this->serializer->serialize($errorMessages, 'json');

            throw new BadRequestHttpException($errorMessagesJson);
        }

        yield $dto;
    }
}
