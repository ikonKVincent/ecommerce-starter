<?php

namespace App\Livewire\Admin\Administrators\Table;

use App\Models\Admins\Admin;
use App\Models\Admins\AdminRole;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\BooleanColumn;
use Rappasoft\LaravelLivewireTables\Views\Filters\MultiSelectDropdownFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;

class AdminsTable extends DataTableComponent
{
    /** @locked */
    public ?string $role_id = null;

    public string $route = 'admin.admins.users';

    /** @locked */
    protected $model = Admin::class;

    /**
     * Activate account
     */
    public function activate(): void
    {
        $this->model::whereIn('id', $this->getSelected())->update(['enabled' => true]);
        $this->model::flushQueryCache();
        $this->clearSelected();
    }

    /**
     * Base query Builder
     */
    public function builder(): Builder
    {
        return Admin::query()
            ->select([config('shop-ik.database.table_prefix') . 'admins.*'])
            ->when(null !== $this->role_id, fn ($query) => $query->where('role_id', $this->role_id))
            ->with(['role']);
    }

    /**
     * Set Bulk Action
     */
    public function bulkActions(): array
    {
        return [
            'activate' => __('admin.admins.users.activate'),
            'desactivate' => __('admin.admins.users.desactivate'),
            'delete' => __('admin.admins.users.delete'),
        ];
    }

    /**
     * Set table Columns
     */
    public function columns(): array
    {
        return [
            // Enabled
            BooleanColumn::make(__('admin.admins.users.table.enabled'), 'enabled')
                ->sortable(),
            // Avatar
            Column::make(__('admin.admins.users.avatar'), 'id')
                ->format(fn ($value, $row, Column $column) => view('admin.components.datatable.image', ['data' => $row, 'image' => 'avatar', 'conversion' => 'avatar']))
                ->html(),
            // Firstname
            Column::make(__('admin.admins.users.table.name'), 'firstname')
                ->searchable()
                ->sortable()
                ->format(function ($value, $row, Column $column) {
                    return view('admin.components.datatable.edit-link', [
                        'route' => $this->route,
                        'id' => $row->id,
                        'name' => $row->displayName()
                    ]);
                })
                ->html(),
            // Email
            Column::make(__('admin.admins.users.table.email'), 'email')
                ->searchable()
                ->sortable()
                ->collapseOnTablet(),
            // Role : name
            Column::make(__('admin.admins.users.table.role'), 'role.name')
                ->eagerLoadRelations()
                ->searchable()
                ->sortable()
                ->format(fn ($value, $row, Column $column) => '<span class="inline-flex rounded-md border py-2 px-4 bg-warning">' . $value . '</span>')
                ->html()
                ->collapseOnTablet(),
            // Created At
            Column::make(__('admin.admins.users.table.created_at'), 'created_at')
                ->searchable()
                ->sortable()
                ->format(fn ($value, $row, Column $column) => $value->toFormattedDateString())
                ->collapseOnTablet(),
            // Action
            Column::make(__('admin.table.action'), 'id')
                ->format(fn ($value, $row, Column $column) => view('admin.components.datatable.actions', ['route' => $this->route, 'id' => $row->id]))
                ->html(),
        ];
    }

    /**
     * Configure the table
     */
    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setSearchEnabled();
        $this->setSearchLazy();
        $this->setUseHeaderAsFooterEnabled();
        $this->setDefaultSort('created_at', 'desc');
        //$this->setDebugEnabled();
    }

    /**
     * Delete
     */
    public function delete(): void
    {
        $this->model::whereIn('id', $this->getSelected())->delete();
        $this->model::flushQueryCache();
        $this->clearSelected();
    }

    /**
     * Desactivate account
     */
    public function desactivate(): void
    {
        $this->model::whereIn('id', $this->getSelected())->update(['enabled' => false]);
        $this->model::flushQueryCache();
        $this->clearSelected();
    }

    /**
     * Set table filters
     */
    public function filters(): array
    {
        return [
            // Enabled
            SelectFilter::make(__('admin.admins.users.table.enabled'), 'enabled')
                ->options([
                    '' => 'Tous',
                    '1' => 'Oui',
                    '0' => 'Non',
                ])
                ->filter(function (Builder $builder, string $value): void {
                    if ('1' === $value) {
                        $builder->where('enabled', true);
                    } elseif ('0' === $value) {
                        $builder->where('enabled', false);
                    }
                }),
            // Rôles
            MultiSelectDropdownFilter::make(__('admin.admins.users.table.role'), 'role_id')
                ->options(
                    AdminRole::query()
                        ->select(['id', 'name'])
                        ->orderBy('name')
                        ->get()
                        ->keyBy('id')
                        ->map(fn ($role) => $role->name)
                        ->toArray()
                )
                ->setFirstOption('Tous les rôles'),
        ];
    }
}
