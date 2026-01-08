<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;

class ExperimentController extends Controller
{

    public function list()
    {
        // Fetch all experiments
        $experiments = DB::table('experiments')
            ->select('experiments.id', 'article_doi', 'data_doi', 'section', 'type', 'path')
            ->leftJoin('experiments_membrane_composition as emc', 'experiments.id', '=', 'emc.experiment_id')
            ->groupBy('experiments.id')
            ->selectRaw('COUNT(emc.lipid_id) as lipid_count')
            ->paginate(10);

        return View::make('experiment', [
            'experiments_list' => $experiments,
        ]);
    }


    public function show($type, $doi, $section)
    {
        // Fetch experiment by DOI, section, and type
        $experiment = DB::table('experiments')
            ->where('article_doi', $doi)
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
        // convert properties with type 'array' or 'dict' from JSON strings to PHP arrays
        foreach ($properties as $prop) {
            if ($prop->type === 'array' || $prop->type === 'dict') {
                $prop->value = json_decode($prop->value, true);
            }
        }
        // Fetch membrane composition property if exists
        $membraneComposition = DB::table('experiments_membrane_composition as emc')
            ->join('lipids as l', 'emc.lipid_id', '=', 'l.id')
            ->where('emc.experiment_id', $experiment->id)
            ->select('l.id','l.name','l.molecule', 'emc.mol_fraction')
            ->get();
        // Fetch solution composition property if exists
        $solutionComposition = DB::table('experiments_solution_composition as esc')
            ->where('esc.experiment_id', $experiment->id)
            ->select('esc.compound', 'esc.concentration',)
            ->get();    

        return View::make('experiment', [
                'entity' => ['doi' => $experiment->article_doi,
                             'data_doi' => $experiment->data_doi,
                            'section' => $experiment->section, 
                            'path' => $experiment->path,
                            'type' => $experiment->type,
                            'membrane_composition' => $membraneComposition,
                            'solution_composition' => $solutionComposition,
                            ],
                'properties' => $properties,
        ]);
    }
}
