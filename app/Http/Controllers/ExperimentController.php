<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;

class ExperimentController extends Controller
{


    public function show($type, $doi, $section)
    {
        // Fetch experiment by DOI, section, and type
        $experiment = DB::table('experiments')
            ->where('doi', $doi)
            ->where('section', $section)
            ->where('type', $type)
            ->first();

        if (!$experiment) {
            abort(404, 'Experiment not found');
        }

        // Fetch associated properties
        $properties = DB::table('experiment_property as ep')
            ->join('experiments_properties_linker as efl', 'ep.id', '=', 'efl.property_id')
            ->where('efl.experiment_id', $experiment->id)
            ->select('ep.name', 'ep.value', 'ep.unit', 'ep.type', 'ep.description')
            ->get();

        return View::make('experiment', [
                'entity' => ['doi' => $experiment->doi, 
                            'section' => $experiment->section, 
                            'path' => $experiment->path,
                            'type' => $experiment->type],
                'properties' => $properties,
        ]);
    }
}
