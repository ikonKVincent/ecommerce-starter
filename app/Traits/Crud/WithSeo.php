<?php

namespace App\Traits\Crud;

use App\Models\Settings\Seo;
use Illuminate\Database\Eloquent\Model;

trait WithSeo
{
    /**
     * Save SEO
     */
    public function saveSeo(Model $model, array $seo): void
    {
        if ($model->seo) {
            // Update
            $model->seo->update([
                'robot' => isset($seo['robot']) ? 1 : 0,
                'title' => $seo['title'] ?? $model->name,
                'description' => $seo['description'],
                'type' => $seo['type'] ?? 'website',
            ]);
        } else {
            // Create
            Seo::create([
                'element_type' => $model->getMorphClass(),
                'element_id' => $model->id,
                'robot' => isset($seo['robot']) ? 1 : 0,
                'title' => $seo['title'] ?? $model->name,
                'description' => $seo['description'],
                'type' => $seo['type'] ?? 'website',
            ]);
        }
    }
}
