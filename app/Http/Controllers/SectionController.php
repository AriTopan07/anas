<?php

namespace App\Http\Controllers;

use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Helpers\NavHelper;
use App\Http\Repository\SectionRepository;
use App\Http\Repository\MenuRepository;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

class SectionController extends Controller
{
    protected $section, $menu;

    public function __construct(SectionRepository $sctn, MenuRepository $menu)
    {
        $this->section = $sctn;
        $this->menu = $menu;
        $this->middleware(function ($request, $next) {
            Session::put('menu_active', '/create-section');
            return $next($request);
        });
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = DB::table('menus')
            ->select('menus.name_menu', 'menus.url', 'menus.section_id', 'menus.icons', 'menus.order')
            ->join('actions', 'actions.menu_id', '=', 'menus.id')
            ->join('master_actions', 'master_actions.id', '=', 'actions.master_action_id')
            ->join('action_groups', 'action_groups.action_id', '=', 'actions.id')
            ->where('master_actions.name', 'lihat')
            ->where('action_groups.group_id', 1)
            ->get();
        $result = [];

        foreach ($data as $value) {
            $hasSection = DB::table('menu_sections')->where('id', $value->section_id)->first();

            if ($hasSection) {
                $sectionData = [
                    'section_id' => $value->section_id,
                    'section' => $hasSection->name_section,
                    'icons' => $hasSection->icons,
                    'order' => $hasSection->order,
                    'menu' => [
                        [
                            'url' => $value->url,
                            'menu' => $value->name_menu,
                            'order' => $value->order
                        ]
                    ]
                ];

                // Check if the section_id already exists in $result
                $sectionIdExists = false;
                foreach ($result as &$existingSection) {
                    if ($existingSection['section_id'] === $value->section_id) {
                        $existingSection['menu'][] = [
                            'url' => $value->url,
                            'menu' => $value->name_menu,
                            'order' => $value->order
                        ];

                        $sectionIdExists = true;
                        break;
                    }
                }

                if (!$sectionIdExists) {
                    $result[] = $sectionData;
                }

                foreach ($result as &$section) {
                    $aktif = [];
                    foreach ($section['menu'] as $menu) {
                        $aktif[] = $menu['url'];
                    }
                    $section['aktif'] = $aktif;
                }
            } else {
                // Menu tanpa section
                $result[] = [
                    'section_id' => $value->section_id,
                    'section' => $value->name_menu,
                    'icons' => $value->icons,
                    'order' => $value->order,
                    'url' => $value->url
                ];
            }
        }

        // Menggunakan usort() untuk mengurutkan $result berdasarkan "order"
        usort($result, function ($a, $b) {
            return $a['order'] <=> $b['order'];
        });

        return response()->json([
            'payload' => $result
        ]);
    }

    public function detailSection($id)
    {
        $data = $this->section->get_section($id);
        $menu = $this->menu->get_menu_by_section($data->id);
        $result = [];

        foreach ($menu as $m) {
            $hasSection = $this->section->get_section($m->section_id);

            if ($hasSection) {
                $sectionData = [
                    'section_id' => $m->section_id,
                    'section' => $hasSection->name_section,
                    'icons' => $hasSection->icons,
                    'order' => $hasSection->order,
                    'status' => $hasSection->status,
                    'menu' => [
                        [
                            'url' => $m->url,
                            'menu' => $m->name_menu,
                            'order' => $m->order
                        ]
                    ]
                ];

                // Check if the section_id already exists in $result
                $sectionIdExists = false;
                foreach ($result as &$existingSection) {
                    if ($existingSection['section_id'] === $m->section_id) {
                        $existingSection['menu'][] = [
                            'url' => $m->url,
                            'menu' => $m->name_menu,
                            'order' => $m->order
                        ];

                        $sectionIdExists = true;
                        break;
                    }
                }

                if (!$sectionIdExists) {
                    $result[] = $sectionData;
                }

                foreach ($result as &$section) {
                    $aktif = [];
                    foreach ($section['menu'] as $menu) {
                        $aktif[] = $menu['url'];
                    }
                    $section['aktif'] = $aktif;
                }
            } else {
                // Menu tanpa section
                $result[] = [
                    'section_id' => $value->section_id,
                    'section' => $value->name_menu,
                    'icons' => $value->icons,
                    'order' => $value->order,
                    'url' => $value->url
                ];
            }
        }

        usort($result, function ($a, $b) {
            return $a['order'] <=> $b['order'];
        });

        return response()->json([
            'payload' => $result
        ]);
    }

    public function section()
    {
        $iconPath = public_path('assets/extensions/bootstrap-icons/icons');
        $icons = File::allFiles($iconPath);
        $data = $this->section->get_all_section();

        return view('page.section.create-section', compact('icons', 'data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name_section' => 'required',
            'icons' => 'required',
        ]);

        $this->section->store($request);

        return back()->with('success', 'Berhasil menambah section baru');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function show(Section $section)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = $this->section->get_section($id);
        $section = $this->section->get_all_section();
        $menu = $this->menu->get_menu_by_section($data->id);
        $listMenu = $this->menu->get_all_menu();
        $iconPath = public_path('assets/extensions/bootstrap-icons/icons');
        $icons = File::allFiles($iconPath);
        return view('page.section.edit', compact('data', 'menu', 'listMenu', 'section', 'icons'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name_section' => 'required',
        ]);

        if (!$request) {
            return back()->with('failed', 'Gagal update section!');
        }

        $this->section->update($request, $id);

        return back()->with('success', 'Berhasil update section');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function destroy(Section $section)
    {
        //
    }

    public function menuBySection()
    {
        $section = $this->section->get_all_section_active();
    }
}
