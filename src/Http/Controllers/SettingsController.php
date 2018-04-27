<?php

namespace Bishopm\Bookclub\Http\Controllers;

use Bishopm\Bookclub\Repositories\SettingsRepository;
use Bishopm\Bookclub\Repositories\SocietiesRepository;
use Bishopm\Bookclub\Repositories\CircuitsRepository;
use Bishopm\Bookclub\Repositories\GroupsRepository;
use Bishopm\Bookclub\Repositories\RostersRepository;
use Bishopm\Bookclub\Repositories\FoldersRepository;
use Bishopm\Bookclub\Repositories\UsersRepository;
use Bishopm\Bookclub\Models\Setting;
use Bishopm\Bookclub\Models\User;
use Bishopm\Bookclub\Models\Roster;
use Spatie\Activitylog\Models\Activity;
use App\Http\Controllers\Controller;
use Bishopm\Bookclub\Http\Requests\CreateSettingRequest;
use Bishopm\Bookclub\Http\Requests\UpdateSettingRequest;
use Spatie\Analytics\Period;
use Analytics;

class SettingsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */

    private $setting;
    private $societies;
    private $groups;
    private $folders;
    private $circuits;
    private $users;

    public function __construct(SettingsRepository $setting, CircuitsRepository $circuits, SocietiesRepository $societies, GroupsRepository $groups, RostersRepository $rosters, FoldersRepository $folders, UsersRepository $users)
    {
        $this->setting = $setting;
        $this->societies = $societies;
        $this->circuits = $circuits;
        $this->groups = $groups;
        $this->folders = $folders;
        $this->rosters = $rosters;
        $this->users=  $users;
    }

    public function index()
    {
        $modules=$this->setting->activemodules();
        $settings = $this->setting->activesettings($modules);
        if (in_array('mcsa', $modules)) {
            foreach ($this->circuits->settings() as $cs) {
                $cs->label=$cs->setting_value;
                $cs->module="churchnet";
                $settings->add($cs);
            }
        }
        return view('bookclub::settings.index', compact('settings'));
    }

    public function modulesindex()
    {
        $modules = $this->setting->allmodules();
        return view('bookclub::settings.modules', compact('modules'));
    }

    public function modulestoggle($module)
    {
        $modules = $this->setting->allmodules();
        $module = $this->setting->find($module);
        if ($module->setting_value=="yes") {
            $module->setting_value="no";
        } else {
            $module->setting_value="yes";
        }
        $module->save();
        return redirect()->route('admin.modules.index');
    }

    public function extedit($id)
    {
        $setting = $this->circuits->setting($id);
        return view('bookclub::settings.extedit', compact('setting'));
    }

    public function edit(Setting $setting)
    {
        if ($setting->setting_key=="society_name") {
            $vals=$this->societies->all();
            $dropdown=array();
            foreach ($vals as $val) {
                $dum[0]=$val->id;
                $dum[1]=$val->society;
                $dropdown[]=$dum;
            }
        } elseif ($setting->setting_key=="filtered_tasks") {
            $vals=$this->folders->dropdown();
            $dropdown=array();
            foreach ($vals as $val) {
                $dum[0]=$val->id;
                $dum[1]=$val->folder;
                $dropdown[]=$dum;
            }
        } elseif ($setting->setting_key=="giving_reports") {
            $vals=array('0','1','2','3','4','6','12');
            $dropdown=array();
            foreach ($vals as $val) {
                $dum[0]=$val;
                $dum[1]=$val;
                $dropdown[]=$dum;
            }
        } elseif ($setting->setting_key=="giving_administrator") {
            $users=User::orderBy('name')->get();
            $count=0;
            foreach ($users as $user) {
                $dropdown[$count][0]=$user->id;
                $dropdown[$count][1]=$user->name;
                $count++;
            }
        } elseif ($setting->setting_key=="sunday_roster") {
            $rosters=Roster::orderBy('rostername')->get();
            $count=0;
            foreach ($rosters as $roster) {
                $dropdown[$count][0]=$roster->id;
                $dropdown[$count][1]=$roster->rostername;
                $count++;
            }
        } elseif ($setting->setting_key=="pastoral_group") {
            $vals=$this->groups->dropdown();
            $dropdown=array();
            foreach ($vals as $val) {
                $dum[0]=$val->id;
                $dum[1]=$val->groupname;
                $dropdown[]=$dum;
            }
        } elseif ($setting->setting_key=="bookshop") {
            $vals=$this->groups->dropdown();
            $dropdown=array();
            foreach ($vals as $val) {
                $dum[0]=$val->id;
                $dum[1]=$val->groupname;
                $dropdown[]=$dum;
            }
        } elseif ($setting->setting_key=="birthday_group") {
            $vals=$this->groups->dropdown();
            $dropdown=array();
            foreach ($vals as $val) {
                $dum[0]=$val->id;
                $dum[1]=$val->groupname;
                $dropdown[]=$dum;
            }
        } elseif ($setting->setting_key=="worship_roster") {
            $vals=$this->rosters->dropdown();
            $dropdown=array();
            foreach ($vals as $val) {
                $dum[0]=$val->id;
                $dum[1]=$val->rostername;
                $dropdown[]=$dum;
            }
        } elseif ($setting->setting_key=="bookshop_manager") {
            $users=User::orderBy('name')->get();
            $count=0;
            foreach ($users as $user) {
                $dropdown[$count][0]=$user->id;
                $dropdown[$count][1]=$user->name;
                $count++;
            }
        } elseif ($setting->setting_key=="website_theme") {
            $dropdown[0][0]="green";
            $dropdown[0][1]="green";
            $dropdown[1][0]="navy";
            $dropdown[1][1]="navy";
            $dropdown[2][0]="red";
            $dropdown[2][1]="red";
        } elseif ($setting->setting_key=="sms_provider") {
            $dropdown[0][0]="bulksms";
            $dropdown[0][1]="bulksms";
            $dropdown[1][0]="smsfactory";
            $dropdown[1][1]="smsfactory";
        } elseif ($setting->setting_key=="worship_administrator") {
            $users=User::orderBy('name')->get();
            $count=0;
            foreach ($users as $user) {
                $dropdown[$count][0]=$user->id;
                $dropdown[$count][1]=$user->name;
                $count++;
            }
        } elseif ($setting->setting_key=="circuit") {
            $circuits=$this->circuits->all();
            $count=0;
            if (count($circuits)>1) {
                foreach ($circuits as $circuit) {
                    $dropdown[$count][0]=$circuit->id;
                    $dropdown[$count][1]=$circuit->circuitnumber . ' ' . $circuit->circuit;
                    $count++;
                }
            } else {
                $dropdown='';
            }
        } else {
            $dropdown='';
        }
        return view('bookclub::settings.edit', compact('setting', 'dropdown'));
    }

    private function settinglabel($setting)
    {
        if (in_array($setting->setting_key, ["birthday_group","bookshop","pastoral_group"])) {
            $setting->label=$this->groups->find($setting->setting_value)->groupname;
        } elseif (in_array($setting->setting_key, ["circuit"])) {
            $setting->label=$this->circuits->find($setting->setting_value)->circuit;
        } elseif (in_array($setting->setting_key, ["society_name"])) {
            $setting->label=$this->societies->find($setting->setting_value)->society;
        } elseif (in_array($setting->setting_key, ["bookshop_manager","giving_administrator","worship_administrator"])) {
            $user=$this->users->find($setting->setting_value);
            $setting->label=$user->individual->firstname . " " . $user->individual->surname;
        } elseif ($setting->setting_key=="sunday_roster") {
            $roster=Roster::find($setting->setting_value);
            $setting->label=$roster->rostername;
        } else {
            $setting->label=$setting->setting_value;
        }
        return $setting->save();
    }

    public function userlogs()
    {
        $activities=Activity::all();
        foreach ($activities as $activity) {
            $user=User::find($activity->causer_id);
            if ($user) {
                $name=$user->individual->firstname . " " . $user->individual->surname;
            } else {
                $name="System";
            }
            if ($activity->subject_type) {
                $obj=$activity->subject_type::find($activity->subject_id);
                $object=substr($activity->subject_type, 1+strrpos($activity->subject_type, '\\'));
                $details=$name . " " . $activity->description . " " . strtolower($object) . " (";
                if ($obj) {
                    if ($object=="Group") {
                        $details.=$obj->groupname . ")";
                    } elseif ($object=="Individual") {
                        $details.=$obj->firstname . " " . $obj->surname . ")";
                    } elseif ($object=="Household") {
                        $details.=$obj->addressee . ")";
                    } elseif ($object=="Song") {
                        $details.=$obj->title . ")";
                    }
                } else {
                    $details.=$activity->subject_id . ")";
                }
            } else {
                $details=$name . " " . $activity->description;
            }
            $activity->details=$details;
        }
        return view('bookclub::settings.userlogs', compact('activities'));
    }

    public function create()
    {
        return view('bookclub::settings.create');
    }

    public function store(CreateSettingRequest $request)
    {
        $this->setting->create($request->all());

        return redirect()->route('admin.settings.index')
            ->withSuccess('New setting added');
    }
    
    public function update(Setting $setting, UpdateSettingRequest $request)
    {
        self::settinglabel($this->setting->update($setting, $request->all()));
        return redirect()->route('admin.settings.index')->withSuccess('Setting has been updated');
    }

    public function extupdate(Setting $setting, UpdateSettingRequest $request)
    {
        $this->circuits->updatesetting($setting->id, $request->all());
        return redirect()->route('admin.settings.index')->withSuccess('Setting has been updated');
    }

    public function analytics()
    {
        $anal=Analytics::fetchMostVisitedPages(Period::days(7), 75);
        $analytics=array();
        foreach ($anal as $ana) {
            $url=$ana['url'];
            if (array_key_exists($url, $analytics)) {
                $analytics[$url]=$analytics[$url]+$ana['pageViews'];
            } else {
                $analytics[$url]=$ana['pageViews'];
            }
        }
        arsort($analytics);
        return view('bookclub::settings.analytics', compact('analytics'));
    }
}
