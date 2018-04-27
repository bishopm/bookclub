<?php namespace Bishopm\Bookclub\Repositories;

use Bishopm\Bookclub\Repositories\EloquentBaseRepository;

class SettingsRepository extends EloquentBaseRepository
{
    public function getarray()
    {
        return $this->model->all()->toArray();
    }

    public function allsettings()
    {
        return $this->model->orderBy('setting_key')->get();
    }

    public function makearray()
    {
        foreach ($this->model->all()->toArray() as $setting) {
            $fin[$setting['setting_key']]=$setting['setting_value'];
        }
        return $fin;
    }

    public function getkey($key)
    {
        $val=$this->model->where('setting_key', $key)->first();
        if ($val) {
            return $val->setting_value;
        } else {
            $this->model->create(['setting_key' => $key,'setting_value' => 'Please add a value for this setting','module' => $module]);
            return "Invalid";
        }
    }
}
