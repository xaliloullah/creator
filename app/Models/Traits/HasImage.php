<?php

namespace App\Models\Traits;


trait HasImage
{
    public function image(): string
    {
        $table = $this->getTable();
        $image = $this->image ?? false;

        if ($image) {
            return "{$table}/{$image}";
        }

        if (in_array($table, ['users', 'clients'])) {
            return 'default-user.png';
        }

        return 'default.png';
    }
}
