<x-button icon="o-arrow-left" class="btn-primary" label="{{ __('admin.form.cancel_return') }}"
    link="{{ route($route . 'index') }}" responsive spinner />
<x-button icon="o-check" class="btn-success text-white" label="{!! __('admin.form.save_return') !!}" type="submit" name="submitbutton"
    value="save" spinner />
<x-button icon="o-plus" class="btn-warning" label="{!! __('admin.form.save_new') !!}" type="submit" name="submitbutton"
    value="save_new" spinner />
