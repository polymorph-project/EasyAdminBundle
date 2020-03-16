<?php

namespace EasyCorp\Bundle\EasyAdminBundle\Field\Configurator;

use EasyCorp\Bundle\EasyAdminBundle\Contracts\Field\FieldConfiguratorInterface;
use EasyCorp\Bundle\EasyAdminBundle\Contracts\Field\FieldInterface;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;

final class ImageConfigurator implements FieldConfiguratorInterface
{
    public function supports(FieldInterface $field, EntityDto $entityDto): bool
    {
        return $field instanceof ImageField;
    }

    public function configure(FieldInterface $field, EntityDto $entityDto, string $action): void
    {
        $configuredBasePath = $field->getCustomOption(ImageField::OPTION_BASE_PATH);
        $formattedValue = $this->getImagePath($field->getValue(), $configuredBasePath);

        $field->setFormattedValue($formattedValue);

        // this check is needed to avoid displaying broken images when image properties are optional
        if (empty($formattedValue) || $formattedValue === rtrim($configuredBasePath ?? '', '/')) {
            $field->setTemplateName('label/empty');
        }
    }

    private function getImagePath(?string $imagePath, ?string $basePath): ?string
    {
        // add the base path only to images that are not absolute URLs (http or https) or protocol-relative URLs (//)
        if (null === $imagePath || 0 !== preg_match('/^(http[s]?|\/\/)/i', $imagePath)) {
            return $imagePath;
        }

        return isset($basePath)
            ? rtrim($basePath, '/').'/'.ltrim($imagePath, '/')
            : '/'.ltrim($imagePath, '/');
    }
}