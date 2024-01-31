<?php

namespace App\Http\Controllers;

use App\Exceptions\CrudException;
use App\Models\Medias\Media;
use App\Traits\Crud\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminCrudController extends Controller
{
    use CrudTrait;

    public function __construct()
    {
        $this->setModel();
        $this->setRoute();
        $this->setView();
    }

    /**
     * Set Model for CRUD operations
     *
     * @return void
     */
    public function setModel(): void
    {
        throw new CrudException(__('admin.crud.no_model'));
    }

    /**
     * Set route for CRUD operations
     *
     * @return void
     */
    public function setRoute(): void
    {
        throw new CrudException(__('admin.crud.no_route'));
    }

    /**
     * Set view for CRUD operations
     *
     * @return void
     */
    public function setView(): void
    {
        throw new CrudException(__('admin.crud.no_view'));
    }

    /**
     * Edit input media alt
     *
     * @param array $alt
     *
     * @return void
     */
    protected function edit_alt(array $alt): void
    {
        if (!empty($alt)) {
            $table_name = (new Media())->getTable();
            DB::beginTransaction();
            foreach ($alt as $id => $name) {
                DB::table($table_name)
                    ->where('id', $id)
                    ->update(['name' => $name]);
            }
            DB::commit();
            Media::flushQueryCache();
        }
    }

    /**
     * Update medias position
     *
     * @param Request $request
     *
     * @return void
     */
    protected function medias_positions(Request $request): void
    {
        // Media positions
        if (!empty($request->input('medias_positions'))) {
            $mediasId = [];
            foreach ($request->input('medias_positions') as $medias_positions) {
                if ($medias_positions) {
                    foreach (explode(',', $medias_positions) as $medias_position) {
                        if ($medias_position) {
                            $mediasId[] = $medias_position;
                        }
                    }
                }
            }
            if (!empty($mediasId)) {
                Media::setNewOrder($mediasId);
            }
        }
    }

    /**
     * Redirect after store / updated operation
     *
     * @param Request $request
     * @param Model $data
     *
     * @return string
     */
    protected function route_admin(Request $request, Model $data): string
    {
        $route = route($this->route . 'index');
        if ('save_edit' === $request->input('submitbutton')) {
            $route = route($this->route . 'edit', ['id' => $data->id]);
        }
        if ('save_new' === $request->input('submitbutton')) {
            $route = route($this->route . 'create');
        }

        return $route;
    }
}
