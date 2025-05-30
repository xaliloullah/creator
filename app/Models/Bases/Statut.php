<?php

namespace App\Models\Bases;

use App\Models\Bases\Color;

class Statut
{
    public const ACTIVE = 'ACTIVE';
    public const INACTIVE = 'INACTIVE';
    public const ACCEPTED = 'ACCEPTED';
    public const REJECTED = 'REJECTED';
    public const READ = 'READ';
    public const UNREAD = 'UNREAD';
    public const PENDING = 'PENDING';
    public const BANNED = 'BANNED';
    public const SUSPENDED = 'SUSPENDED';
    public const DELETED = 'DELETED';
    public const VERIFIED = 'VERIFIED';
    public const UNVERIFIED = 'UNVERIFIED';
    public const PROCESSING = 'PROCESSING';
    public const SHIPPED = 'SHIPPED';
    public const DELIVERED = 'DELIVERED';
    public const CANCELED = 'CANCELED';
    public const REFUNDED = 'REFUNDED';
    public const FAILED = 'FAILED';
    public const COMPLETED = 'COMPLETED';
    public const DRAFT = 'DRAFT';
    public const PUBLISHED = 'PUBLISHED';
    public const UNPUBLISHED = 'UNPUBLISHED';
    public const ARCHIVED = 'ARCHIVED';
    public const PENDING_REVIEW = 'PENDING_REVIEW';
    public const OPEN = 'OPEN';
    public const IN_PROGRESS = 'IN_PROGRESS';
    public const RESOLVED = 'RESOLVED';
    public const CLOSED = 'CLOSED';
    public const NEW = 'NEW';

    private string $value;
    private string $name;
    private string $color;
    private string $icon;
    private static array $data = [];

    // Tableau des attributs
    private static array $attributes = [
        self::ACTIVE => [
            'color' => Color::SUCCESS,
            'icon' => 'bi-check-circle',
            'name' => 'Actif',
            'is-active' => true,
            'is-final' => false
        ],
        self::INACTIVE => [
            'color' => Color::WARNING,
            'icon' => 'bi-x-circle',
            'name' => 'Inactif',
            'is-active' => false,
            'is-final' => false
        ],
        self::ACCEPTED => [
            'color' => Color::SUCCESS,
            'icon' => 'bi-check-lg',
            'name' => 'Accepté',
            'is-active' => true,
            'is-final' => false
        ],
        self::REJECTED => [
            'color' => Color::DANGER,
            'icon' => 'bi-x-circle',
            'name' => 'Rejeté',
            'is-active' => false,
            'is-final' => true
        ],
        self::READ => [
            'color' => Color::PRIMARY,
            'icon' => 'bi-eye',
            'name' => 'Lu',
            'is-active' => false,
            'is-final' => true
        ],
        self::UNREAD => [
            'color' => Color::SECONDARY,
            'icon' => 'bi-eye-slash',
            'name' => 'Non lu',
            'is-active' => false,
            'is-final' => false
        ],
        self::PENDING => [
            'color' => Color::WARNING,
            'icon' => 'bi-hourglass-split',
            'name' => 'En attente',
            'is-active' => false,
            'is-final' => false
        ],
        self::BANNED => [
            'color' => Color::DANGER,
            'icon' => 'bi-ban',
            'name' => 'Banni',
            'is-active' => false,
            'is-final' => true
        ],
        self::SUSPENDED => [
            'color' => Color::WARNING,
            'icon' => 'bi-pause-circle',
            'name' => 'Suspendu',
            'is-active' => false,
            'is-final' => false
        ],
        self::DELETED => [
            'color' => Color::DANGER,
            'icon' => 'bi-trash',
            'name' => 'Supprimé',
            'is-active' => false,
            'is-final' => true
        ],
        self::VERIFIED => [
            'color' => Color::SUCCESS,
            'icon' => 'bi-check-lg',
            'name' => 'Vérifié',
            'is-active' => true,
            'is-final' => false
        ],
        self::UNVERIFIED => [
            'color' => Color::WARNING,
            'icon' => 'bi-exclamation-circle',
            'name' => 'Non vérifié',
            'is-active' => false,
            'is-final' => false
        ],
        self::PROCESSING => [
            'color' => Color::INFO,
            'icon' => 'bi-arrow-clockwise',
            'name' => 'Traitement',
            'is-active' => false,
            'is-final' => false
        ],
        self::SHIPPED => [
            'color' => Color::DARK,
            'icon' => 'bi-truck',
            'name' => 'Expédié',
            'is-active' => false,
            'is-final' => false
        ],
        self::DELIVERED => [
            'color' => Color::PRIMARY,
            'icon' => 'bi-box',
            'name' => 'Livré',
            'is-active' => false,
            'is-final' => true
        ],
        self::NEW => [
            'color' => Color::DANGER,
            'icon' => 'bi-plus-circle',
            'name' => 'Nouveau',
            'is-active' => true,
            'is-final' => false
        ],

    ];

    public function __construct(string $value = 'INACTIVE')
    {
        $this->value = strtoupper($value);
        $this->name = self::$attributes[$value]['name'] ?? 'Inconnu';
        $this->color = self::$attributes[$value]['color'] ?? Color::SECONDARY;
        $this->icon = self::$attributes[$value]['icon'] ?? 'bi-question-circle';
    }

    public function __get(string $property)
    {
        return $this->$property ?? null;
    }

    public static function initialize(): void
    {
        foreach (self::$attributes as $key => $attr) {
            self::$data[$key] = new self($key);
        }
    }

    public static function all(): array
    {
        return self::$data;
    }

    public static function get(?string $value): ?self
    {
        return self::$data[strtoupper($value)] ?? self::$data[self::INACTIVE];
    }

    public function isActive(): bool
    {
        return self::$attributes[$this->value]['is-active'] ?? false;
    }

    public function isFinal(): bool
    {
        return self::$attributes[$this->value]['is-final'] ?? false;
    }

    public static function forUser(): array
    {
        return self::getStatuses([self::ACTIVE, self::INACTIVE, self::VERIFIED, self::UNVERIFIED, self::BANNED, self::SUSPENDED]);
    }

    public static function forArticle(): array
    {
        return self::getStatuses([self::PENDING, self::PROCESSING, self::SHIPPED, self::DELIVERED, self::CANCELED, self::REFUNDED, self::FAILED, self::COMPLETED]);
    }

    public static function forContent(): array
    {
        return self::getStatuses([self::DRAFT, self::PUBLISHED, self::UNPUBLISHED, self::ARCHIVED, self::ACCEPTED, self::REJECTED]);
    }

    public static function forTicket(): array
    {
        return self::getStatuses([self::OPEN, self::IN_PROGRESS, self::RESOLVED, self::CLOSED]);
    }

    public static function forState(): array
    {
        return self::getStatuses([self::ACTIVE, self::INACTIVE]);
    }

    public static function forConfirm(): array
    {
        return self::getStatuses([self::ACCEPTED, self::REJECTED]);
    }

    private static function getStatuses(array $values): array
    {
        return array_map(fn($value) => self::get($value), $values);
    }
}
