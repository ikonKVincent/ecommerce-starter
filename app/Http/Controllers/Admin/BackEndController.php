<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class BackEndController extends Controller
{
    /**
     * Dashboard page
     * @param Request $request
     *
     * @return View
     */
    public function dashboard(Request $request): View
    {
        // Alert user
        $alert_message = [];
        if (!File::exists(public_path() . '/storage')) {
            $alert_message[] = "
                <strong>Le lien symobolique pour l'upload de fichier n'est pas en place.</strong>
                Veuillez l'activer en <a href='" . route('admin.storage.link') . "' class='underline'>cliquant ici</a>.
            ";
        }
        if (env('APP_DEBUG')) {
            $alert_message[] = "
                Le mode debug est <strong><u>activé !</u></strong> Il ne doit être activé qu'en développement.
            ";
        }

        return view('admin.dashboard', [
            'seo_title' => null,
            'seo_description' => null,
            'seo_robot' => false,
            'alert_message' => $alert_message,
            'total_alert' => count($alert_message)
        ]);
    }
    /**
     * Storage link
     * @return RedirectResponse
     */
    public function storage_link(): RedirectResponse
    {
        if (!File::exists(public_path() . '/storage')) {
            Artisan::call('storage:link');
            session()->flash('success', 'Le lien symbolique a bien été créé.');
        } else {
            session()->flash('error', 'Le lien symbolique a déja été créé.');
        }

        return redirect()->route('admin.dashboard');
    }

    /**
     * Update Migrations
     * @return RedirectResponse
     */
    public function update_migrations(): RedirectResponse
    {

        /*$medias = Media::query()->where('model_type', 'Domain\WebTv\Models\WebtvVideo')->where('created_at', '<=', '2024-01-23')->get();
        foreach ($medias as $media) {
            if (Storage::disk('public')->exists($media->id . '/' . $media->file_name)) {
                Storage::disk('public')->deleteDirectory($media->id);
            }
            $media->delete();
        }
        $medias = Media::query()->where('model_type', 'Domain\WebTv\Models\WebtvArticle')->where('created_at', '<=', '2024-01-23')->get();
        foreach ($medias as $media) {
            if (Storage::disk('public')->exists($media->id . '/' . $media->file_name)) {
                Storage::disk('public')->deleteDirectory($media->id);
            }
            $media->delete();
        }*/

        Artisan::call('migrate', [
            '--force' => true,
        ]);
        session()->flash('success', 'La mise à jours a bien été faite.');

        return redirect()->route('admin.dashboard');
    }
}
