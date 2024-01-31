<?php

namespace App\Livewire\Admin\Administrators\Table;

use App\Models\Admins\AdminRole;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class AdminRolesTable extends DataTableComponent
{
    protected $model = AdminRole::class;

    public string $route = 'admin.admins.roles';

    /**
     * Base query Builder
     */
    public function builder(): Builder
    {
        return AdminRole::query()
            ->withCount(['admins']);
    }

    /**
     * Set table Columns
     */
    public function columns(): array
    {
        return [
            // Name
            Column::make(__('admin.admins.roles.table.name'), 'name')
                ->searchable()
                ->sortable()
                ->format(function ($value, $row, Column $column) {
                    if ($row->name === config('akawam.admin.superAdmin')) {
                        return $value;
                    }
                    return view('admin.components.datatable.edit-link', [
                        'route' => $this->route,
                        'id' => $row->id,
                        'name' => $value
                    ]);
                })
                ->html(),
            // Admins count
            Column::make(__('admin.admins.roles.admins'), 'id')
                ->searchable()
                ->sortable()
                ->format(fn ($value, $row, Column $column) => '<span class="inline-flex rounded-md border py-2 px-4 bg-warning">' . $row->admins_count . '<span>')
                ->html()
                ->collapseOnTablet(),
            // Created at
            Column::make(__('admin.admins.roles.table.created_at'), 'created_at')
                ->searchable()
                ->sortable()
                ->format(fn ($value, $row, Column $column) => $value->toFormattedDateString())
                ->collapseOnTablet(),
            // Action
            Column::make(__('admin.table.action'), 'id')
                ->format(function ($value, $row, Column $column) {
                    if ($row->name === config('akawam.admin.superAdmin')) {
                        return null;
                    }
                    return view('admin.components.datatable.actions', ['route' => $this->route, 'id' => $row->id]);
                })
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
}
