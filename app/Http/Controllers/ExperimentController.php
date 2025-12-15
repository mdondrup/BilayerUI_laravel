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
        // Fetch membrane composition property if exists
        $membraneComposition = DB::table('experiments_membrane_composition as emc')
            ->join('lipids as l', 'emc.lipid_id', '=', 'l.id')
            ->where('emc.experiment_id', $experiment->id)
            ->select('l.id','l.name', 'emc.mol_fraction',)
            ->get();
        // Fetch solution composition property if exists
        $solutionComposition = DB::table('experiment_solution_composition as esc')
            ->join('heteromolecules as h', 'esc.heteromolecule_id', '=', 'h.id')
            ->where('esc.experiment_id', $experiment->id)
            ->select('h.id','h.name', 'esc.concentration',)
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
