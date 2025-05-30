<?php

namespace App\Enums;

enum Icon: string
{
    case PERSON = 'bi-person';
    case PERSON_BADGE = 'bi-person-badge';
    case PERSON_CHECK = 'bi-person-check';
    case PERSON_X = 'bi-person-x';
    case SHIELD_LOCK = 'bi-shield-lock';
    case SHIELD_CHECK = 'bi-shield-check';
    case PERSON_DASH = 'bi-person-dash';
    case CODE_SLASH = 'bi-code-slash';
    case KEY = 'bi-key';
    case LOCK = 'bi-lock';
    case UNLOCK = 'bi-unlock';
    case PEOPLE = 'bi-people';
    case CLIPBOARD_CHECK = 'bi-clipboard-check';
    case FILE_LOCK = 'bi-file-lock';
    case FILE_EARMARK_LOCK = 'bi-file-earmark-lock';
    case DOOR_CLOSED = 'bi-door-closed';
    case DOOR_OPEN = 'bi-door-open';
    case EXCLAMATION_CIRCLE = 'bi-exclamation-circle';
    case CHECK_CIRCLE = 'bi-check-circle';
    case X_CIRCLE = 'bi-x-circle';
    case PENCIL_SQUARE = 'bi-pencil-square';
    case TRASH = 'bi-trash';
    case PENCIL = 'bi-pencil';
    case PENCIL_FILL = 'bi-pencil-fill';
    case EYE = 'bi-eye';
    case EYE_SLASH = 'bi-eye-slash';
    case ARROW_RIGHT_CIRCLE = 'bi-arrow-right-circle';
    case ARROW_LEFT_CIRCLE = 'bi-arrow-left-circle';
    case BELL = 'bi-bell';
    case BELL_FILL = 'bi-bell-fill';
    case GEAR = 'bi-gear';
    case GEAR_FILL = 'bi-gear-fill';
    case SEARCH = 'bi-search';
    case SEARCH_HEART = 'bi-search-heart';
    case HOUSE_DOOR = 'bi-house-door';
    case HOUSE = 'bi-house';
    case GRAPH_UP = 'bi-graph-up';
    case GRAPH_DOWN = 'bi-graph-down';
    case ARROW_UP = 'bi-arrow-up';
    case ARROW_DOWN = 'bi-arrow-down';
    case ARROW_LEFT = 'bi-arrow-left';
    case ARROW_RIGHT = 'bi-arrow-right';
    case ARROW_UP_CIRCLE = 'bi-arrow-up-circle';
    case ARROW_DOWN_CIRCLE = 'bi-arrow-down-circle';
    case CHECK = 'bi-check-lg';
    case X = 'bi-x-lg';
    case QUESTION_CIRCLE = 'bi-question-circle';
    case INFO_CIRCLE = 'bi-info-circle';
    case CALENDAR_CHECK = 'bi-calendar-check';
    case CALENDAR_X = 'bi-calendar-x';
    case FILE_EARMARK_TEXT = 'bi-file-earmark-text';
    case FILE_EARMARK_PDF = 'bi-file-earmark-pdf';
    case FILE_EARMARK_EXCEL = 'bi-file-earmark-excel';
    case FILE_EARMARK_WORD = 'bi-file-earmark-word';
    case FILE_EARMARK_IMAGE = 'bi-file-earmark-image';
    case CLOUD = 'bi-cloud';
    case CLOUD_FILL = 'bi-cloud-fill';
    case CLOUD_UPLOAD = 'bi-cloud-upload';
    case CLOUD_DOWNLOAD = 'bi-cloud-download';
    case CLOUD_CHECK = 'bi-cloud-check';
    case PATCH_CHECK = 'bi-patch-check';
    case PATCH_CHECK_FILL = 'bi-patch-check-fill';
    case PATCH_EXCLAMATION = 'bi-patch-exclamation';
    case PATCH_EXCLAMATION_FILL = 'bi-patch-exclamation-fill';
    case AWARD_FILL = 'bi-award-fill';
    case BRIEFCASE_FILL = 'bi-briefcase-fill';





    public static function all(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function random(): string
    {
        return self::cases()[array_rand(self::cases())]->value;
    }
}
