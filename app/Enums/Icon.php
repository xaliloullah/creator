<?php

namespace App\Enums;

enum Icon: string
{
    case PERSON = 'bi bi-person';
    case PERSON_BADGE = 'bi bi-person-badge';
    case PERSON_CHECK = 'bi bi-person-check';
    case PERSON_X = 'bi bi-person-x';
    case SHIELD_LOCK = 'bi bi-shield-lock';
    case SHIELD_CHECK = 'bi bi-shield-check';
    case PERSON_DASH = 'bi bi-person-dash';
    case CODE_SLASH = 'bi bi-code-slash';
    case KEY = 'bi bi-key';
    case LOCK = 'bi bi-lock';
    case UNLOCK = 'bi bi-unlock';
    case PEOPLE = 'bi bi-people';
    case CLIPBOARD_CHECK = 'bi bi-clipboard-check';
    case FILE_LOCK = 'bi bi-file-lock';
    case FILE_EARMARK_LOCK = 'bi bi-file-earmark-lock';
    case DOOR_CLOSED = 'bi bi-door-closed';
    case DOOR_OPEN = 'bi bi-door-open';
    case EXCLAMATION_CIRCLE = 'bi bi-exclamation-circle';
    case CHECK_CIRCLE = 'bi bi-check-circle';
    case X_CIRCLE = 'bi bi-x-circle';
    case PENCIL_SQUARE = 'bi bi-pencil-square';
    case TRASH = 'bi bi-trash';
    case PENCIL = 'bi bi-pencil';
    case PENCIL_FILL = 'bi bi-pencil-fill';
    case EYE = 'bi bi-eye';
    case EYE_SLASH = 'bi bi-eye-slash';
    case ARROW_RIGHT_CIRCLE = 'bi bi-arrow-right-circle';
    case ARROW_LEFT_CIRCLE = 'bi bi-arrow-left-circle';
    case BELL = 'bi bi-bell';
    case BELL_FILL = 'bi bi-bell-fill';
    case GEAR = 'bi bi-gear';
    case GEAR_FILL = 'bi bi-gear-fill';
    case SEARCH = 'bi bi-search';
    case SEARCH_HEART = 'bi bi-search-heart';
    case HOUSE_DOOR = 'bi bi-house-door';
    case HOUSE = 'bi bi-house';
    case GRAPH_UP = 'bi bi-graph-up';
    case GRAPH_DOWN = 'bi bi-graph-down';
    case ARROW_UP = 'bi bi-arrow-up';
    case ARROW_DOWN = 'bi bi-arrow-down';
    case ARROW_LEFT = 'bi bi-arrow-left';
    case ARROW_RIGHT = 'bi bi-arrow-right';
    case ARROW_UP_CIRCLE = 'bi bi-arrow-up-circle';
    case ARROW_DOWN_CIRCLE = 'bi bi-arrow-down-circle';
    case CHECK = 'bi bi-check-lg';
    case X = 'bi bi-x-lg';
    case QUESTION_CIRCLE = 'bi bi-question-circle';
    case INFO_CIRCLE = 'bi bi-info-circle';
    case CALENDAR_CHECK = 'bi bi-calendar-check';
    case CALENDAR_X = 'bi bi-calendar-x';
    case FILE_EARMARK_TEXT = 'bi bi-file-earmark-text';
    case FILE_EARMARK_PDF = 'bi bi-file-earmark-pdf';
    case FILE_EARMARK_EXCEL = 'bi bi-file-earmark-excel';
    case FILE_EARMARK_WORD = 'bi bi-file-earmark-word';
    case FILE_EARMARK_IMAGE = 'bi bi-file-earmark-image';
    case CLOUD = 'bi bi-cloud';
    case CLOUD_FILL = 'bi bi-cloud-fill';
    case CLOUD_UPLOAD = 'bi bi-cloud-upload';
    case CLOUD_DOWNLOAD = 'bi bi-cloud-download';
    case CLOUD_CHECK = 'bi bi-cloud-check';
    case PATCH_CHECK = 'bi bi-patch-check';
    case PATCH_CHECK_FILL = 'bi bi-patch-check-fill';
    case PATCH_EXCLAMATION = 'bi bi-patch-exclamation';
    case PATCH_EXCLAMATION_FILL = 'bi bi-patch-exclamation-fill';
    case AWARD_FILL = 'bi bi-award-fill';
    case BRIEFCASE_FILL = 'bi bi-briefcase-fill';
    case CHAT = 'bi bi-chat';
    case SPEEDOMETER2 = 'bi bi-speedometer2';
    case KANBAN = 'bi bi-kanban';
    case UI_CHECKS_GRID = 'bi bi-ui-checks-grid';
    case UI_CHECKS = 'bi bi-ui-checks';
    case GRID = 'bi bi-grid';
    case BRIEFCASE = 'bi bi-briefcase';
    case FILE_PERSON = 'bi bi-file-person';
    case PERSON_VCARD = 'bi bi-person-vcard';
    case QR_CODE = 'bi bi-qr-code';
    case ENVELOPE = 'bi bi-envelope';
    case SHOP = 'bi bi-shop';
    case CART3 = 'bi bi-cart3';
    case BOX = 'bi bi-box';
    case BOXES = 'bi bi-boxes';
    case RECEIPT = 'bi bi-receipt';
    case FILE_EARMARK = 'bi bi-file-earmark';
    case BANK = 'bi bi-bank';
    case PERSON_CIRCLE = 'bi bi-person-circle';
    case JOURNALS = 'bi bi-journals';
    case CASH_COIN = 'bi bi-cash-coin';
    case CASH_STACK = 'bi bi-cash-stack';
    case PERSON_WORKSPACE = 'bi bi-person-workspace';
    case PERSON_VCARD_FILL = 'bi bi-person-vcard-fill';
    case PERSON_BADGE_FILL = 'bi bi-person-badge-fill';
    case CLOCK_FILL = 'bi bi-clock-fill';
    case FILE_EARMARK_CODE_FILL = 'bi bi-file-earmark-code-fill';






    public static function all(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function random(): string
    {
        return self::cases()[array_rand(self::cases())]->value;
    }
}
