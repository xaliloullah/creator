<?php

namespace App\Models\Traits;

trait Jsonify
{
    public function getParametreAttribute($value = null): array
    {
        $defaults = [
            'devise' => session('devise', settings('devise')),
            'lang' => 'fr',
            'theme' => 'light',
            'color' => 'secondary'
        ];
        return array_merge($defaults, json_decode($value ?? '{}', true) ?: []);
    }

    public function getTagsAttribute($value = null): array
    {
        return json_decode($value ?? '{}', true) ?? [];
    }

    public function getAdresseAttribute($value = null): array
    {
        $defaults = [
            'rue' => '',
            'complement' => '',
            'ville' => '',
            'code_postal' => '',
            'pays' => ''
        ];
        return array_merge($defaults, json_decode($value ?? '{}', true) ?: []);
    }

    public function getTelephonesAttribute($value = null): array
    {
        return json_decode($value ?? '{}', true) ?? [];
    }

    public function getSiteWebAttribute($value = null): array
    {
        return json_decode($value ?? '{}', true) ?? [];
    }

    public function getReseauxSociauxAttribute($value = null): array
    {
        return json_decode($value ?? '{}', true) ?? [];
    }

    public function getLanguesAttribute($value = null): array
    {
        return json_decode($value ?? '{}', true) ?? [];
    }

    public function getFormationsAttribute($value = null): array
    {
        return json_decode($value ?? '{}', true) ?? [];
    }

    public function getCompetencesAttribute($value = null): array
    {
        return json_decode($value ?? '{}', true) ?? [];
    }

    public function getExperiencesAttribute($value = null): array
    {
        return json_decode($value ?? '{}', true) ?? [];
    }

    public function getCertificationsAttribute($value = null): array
    {
        return json_decode($value ?? '{}', true) ?? [];
    }

    public function getLiensAttribute($value = null): array
    {
        return json_decode($value ?? '{}', true) ?? [];
    }

    public function getInteretsAttribute($value = null): array
    {
        return json_decode($value ?? '{}', true) ?? [];
    }
    public function getPermisAttribute($value = null): array
    {
        return json_decode($value ?? '{}', true) ?? [];
    }
}
