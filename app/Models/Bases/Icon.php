<?php

namespace App\Models\Bases;


class Icon
{
    public const PERSON = 'bi-person';
    public const PERSON_BADGE = 'bi-person-badge';
    public const PERSON_CHECK = 'bi-person-check';
    public const PERSON_X = 'bi-person-x';
    public const SHIELD_LOCK = 'bi-shield-lock';
    public const SHIELD_CHECK = 'bi-shield-check';
    public const PERSON_DASH = 'bi-person-dash';
    public const CODE_SLASH = 'bi-code-slash';
    public const KEY = 'bi-key';
    public const LOCK = 'bi-lock';
    public const UNLOCK = 'bi-unlock';
    public const PEOPLE = 'bi-people';
    public const CLIPBOARD_CHECK = 'bi-clipboard-check';
    public const FILE_LOCK = 'bi-file-lock';
    public const FILE_EARMARK_LOCK = 'bi-file-earmark-lock';
    public const DOOR_CLOSED = 'bi-door-closed';
    public const DOOR_OPEN = 'bi-door-open';
    public const EXCLAMATION_CIRCLE = 'bi-exclamation-circle';
    public const CHECK_CIRCLE = 'bi-check-circle';
    public const X_CIRCLE = 'bi-x-circle';
    public const PENCIL_SQUARE = 'bi-pencil-square';
    public const TRASH = 'bi-trash';
    public const PENCIL = 'bi-pencil';
    public const PENCIL_FILL = 'bi-pencil-fill';
    public const EYE = 'bi-eye';
    public const EYE_SLASH = 'bi-eye-slash';
    public const ARROW_RIGHT_CIRCLE = 'bi-arrow-right-circle';
    public const ARROW_LEFT_CIRCLE = 'bi-arrow-left-circle';
    public const BELL = 'bi-bell';
    public const BELL_FILL = 'bi-bell-fill';
    public const GEAR = 'bi-gear';
    public const GEAR_FILL = 'bi-gear-fill';
    public const SEARCH = 'bi-search';
    public const SEARCH_HEART = 'bi-search-heart';
    public const HOUSE_DOOR = 'bi-house-door';
    public const HOUSE = 'bi-house';
    public const GRAPH_UP = 'bi-graph-up';
    public const GRAPH_DOWN = 'bi-graph-down';
    public const ARROW_UP = 'bi-arrow-up';
    public const ARROW_DOWN = 'bi-arrow-down';
    public const ARROW_LEFT = 'bi-arrow-left';
    public const ARROW_RIGHT = 'bi-arrow-right';
    public const ARROW_UP_CIRCLE = 'bi-arrow-up-circle';
    public const ARROW_DOWN_CIRCLE = 'bi-arrow-down-circle';
    public const CHECK = 'bi-check-lg';
    public const X = 'bi-x-lg';
    public const QUESTION_CIRCLE = 'bi-question-circle';
    public const INFO_CIRCLE = 'bi-info-circle';
    public const CALENDAR_CHECK = 'bi-calendar-check';
    public const CALENDAR_X = 'bi-calendar-x';
    public const FILE_EARMARK_TEXT = 'bi-file-earmark-text';
    public const FILE_EARMARK_PDF = 'bi-file-earmark-pdf';
    public const FILE_EARMARK_EXCEL = 'bi-file-earmark-excel';
    public const FILE_EARMARK_WORD = 'bi-file-earmark-word';
    public const FILE_EARMARK_IMAGE = 'bi-file-earmark-image';
    public const CLOUD = 'bi-cloud';
    public const CLOUD_FILL = 'bi-cloud-fill';
    public const CLOUD_UPLOAD = 'bi-cloud-upload';
    public const CLOUD_DOWNLOAD = 'bi-cloud-download';
    public const CLOUD_CHECK = 'bi-cloud-check';
    public const PATCH_CHECK = 'bi-patch-check';
    public const PATCH_CHECK_FILL = 'bi-patch-check-fill';
    public const PATCH_EXCLAMATION = 'bi-patch-exclamation';
    public const PATCH_EXCLAMATION_FILL = 'bi-patch-exclamation-fill';
    public const AWARD_FILL = 'bi-award-fill';
    public const BRIEFCASE_FILL = 'bi-briefcase-fill';

    private string $value;
    private string $name;
    private string $contrast;

    private static array $data = [];

    // Tableau des attributs
    private static array $attributes = [];

    public function __construct(string $value)
    {
        $this->value = $value ?? 'secondary';
        $this->name = self::$attributes[$value]['name'] ?? 'Inconnu';
        $this->contrast = self::$attributes[$value]['contrast'] ?? false;
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
        return self::$data[$value] ?? null;
    }

    public static function random(): self
    {
        $values = self::all();
        return self::get($values[array_rand($values)]);
    }

    public function __toString(): string
    {
        return (string) $this->value;
    }
}
