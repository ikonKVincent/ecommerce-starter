<?php

namespace App\Console\Commands;

use App\Base\FieldTypes\TranslatedText;
use App\Models\Admins\Admin;
use App\Models\Admins\AdminRole;
use App\Models\Pages\Page;
use App\Models\Pages\PageType;
use App\Models\Settings\Attribute;
use App\Models\Settings\AttributeGroup;
use App\Models\Settings\Language;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class InstallProject extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'install-ecommerce-starter';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install Project';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->newLine();
        $this->comment('Installation du projet...');

        $this->newLine();
        $this->info('Publication de la configuration...');

        if ($this->confirm('Exécuter les migrations de bases de données?', true)) {
            $this->call('migrate');
        }
        DB::transaction(function (): void {
            // Default Language
            Language::flushQueryCache();
            if (!Language::count()) {
                $this->info('Ajout de la langue par défaut');
                Language::create([
                    'code' => 'fr',
                    'name' => 'Français',
                    'default' => true,
                ]);
                $this->newLine();
                $this->info('Création de la langue FR créée.');
            }
            // Admin
            AdminRole::flushQueryCache();
            Admin::flushQueryCache();
            // Admin Role
            if (!AdminRole::count()) {
                $this->info('Configuration des rôles d\'administrateur par défaut');
                AdminRole::create([
                    'name' => config('akawam.admin.superAdmin'),
                ]);
                AdminRole::create([
                    'name' => 'Admin',
                ]);
            }
            // Admin
            if (!Admin::count()) {
                $this->info('Créer un administrateur');
                $role = AdminRole::query()->where('name', 'SuperAdmin')->first();
                $firstname = $this->ask('Quel est votre prénom?');
                $lastname = $this->ask('Quel est votre nom?');
                $email = $this->ask('Quel est votre email?');
                $password = $this->secret('Saisissez votre mot de passe');
                Admin::create([
                    'enabled' => 1,
                    'role_id' => $role->id,
                    'firstname' => $firstname,
                    'lastname' => $lastname,
                    'email' => $email,
                    'password' => bcrypt($password),
                ]);
            }
            // Attributes
            Attribute::flushQueryCache();
            if (!Attribute::count()) {
                $this->info('Configuration des attributs par défaut');
                $pageGroup = AttributeGroup::create([
                    'attributable_type' => Page::class,
                    'name' => collect([
                        'fr' => 'Détails',
                    ]),
                    'handle' => 'details',
                    'position' => 1,
                ]);
                Attribute::create([
                    'attribute_type' => Page::class,
                    'attribute_group_id' => $pageGroup->id,
                    'position' => 1,
                    'name' => [
                        'fr' => 'Titre',
                    ],
                    'handle' => 'name',
                    'section' => 'main',
                    'type' => TranslatedText::class,
                    'required' => true,
                    'default_value' => null,
                    'configuration' => [
                        'richtext' => false,
                    ],
                    'system' => true,
                ]);
                Attribute::create([
                    'attribute_type' => Page::class,
                    'attribute_group_id' => $pageGroup->id,
                    'position' => 2,
                    'name' => [
                        'en' => 'Description',
                    ],
                    'handle' => 'description',
                    'section' => 'main',
                    'type' => TranslatedText::class,
                    'required' => false,
                    'default_value' => null,
                    'configuration' => [
                        'richtext' => true,
                    ],
                    'system' => false,
                ]);
                $this->newLine();
                $this->info('Attributs par défaut créés.');
            }
            // Page Types
            PageType::flushQueryCache();
            if (!PageType::count()) {
                $this->info('Ajouter un type de page.');
                $type = PageType::create([
                    'name' => 'Par défaut',
                ]);
                $sync_attributes = [];
                foreach (Attribute::whereAttributeType(Page::class)->get()->pluck('id') as $k => $attribute) {
                    $sync_attributes[$attribute] = ['id' => Str::lower(Str::ulid()->toBase32())];
                }
                $type->mappedAttributes()->sync($sync_attributes, true);
                $this->newLine();
                $this->info('Type de page par défaut créé.');
            }
        });
        $this->newLine();
        $this->comment('Le projet est installé 🚀');
        $this->newLine();
        return Command::SUCCESS;
    }
}
