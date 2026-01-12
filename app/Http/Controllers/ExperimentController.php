<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;


class ExperimentController extends Controller
{
    // Function to format data for charting, returns formatted data and min/max values
    private  static function formatData(string $jsonData, int $mult=1): array | null
    {
        $inputData = json_decode($jsonData, true);
        $data = array();
        $max = -INF;
        $min = INF;
        if ($mult == 0) {
            $fact = 1;
        } else {
            $fact = $mult;
        }
        foreach ($inputData as $Values) {
            if ($min > $Values[1]) {
                $min = $Values[1];
            }
            if ($max < $Values[1]) {
                $max = $Values[1];
            }

            //$labelData = $labelData . "'" . $Values[0] . "',";
            if ($mult == 0) {
                $normal0 = $Values[0];
            } else {
                $normal0 = $Values[0] + 0.15;
            }
            $normal = $Values[1] * $fact;
            //$data = $data . "'" . $normal . "',";
            $d = array('x' => $normal0, 'y'=> $normal);

            $data[]= $d;
        }
        $min = round($min - 0.5);
        $max = round($max + 0.5);
        $jsondata = str_replace('"',"",json_encode($data));
        return array('data'=>$jsondata, 'min'=>$min, 'max'=>$max);
    }





    public function list(): \Illuminate\View\View
    {
        // Fetch all experiments
        $experiments = DB::table('experiments as e')
            ->select('e.id', 'e.article_doi', 'e.data_doi', 'e.section', 'e.type', 'e.path')
            ->leftJoin('experiments_membrane_composition as emc', 'e.id', '=', 'emc.experiment_id')
            ->groupBy('e.id')
            ->orderBy('type', 'asc')
            ->orderBy('article_doi', 'asc')
            ->orderBy('section', 'asc')
            
            ->selectRaw('COUNT(emc.lipid_id) as lipid_count')
            ->paginate(10);

        return View::make('experiment', [
            'experiments_list' => $experiments,
        ]);
    }


    public function show($type, $doi, $section): \Illuminate\View\View
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
        $datFF = !empty($experiment->data) ? $this->formatData($experiment->data) : null;
        return View::make('experiment', [
                'entity' => ['doi' => $experiment->article_doi,
                             'data_doi' => $experiment->data_doi,
                            'section' => $experiment->section, 
                            'path' => $experiment->path,
                            'type' => ($experiment->type),
                            'data' => $datFF['data'] ?? null,
                            'data_min' => $datFF['min'] ?? null,
                            'data_max' => $datFF['max'] ?? null,
                            'membrane_composition' => $membraneComposition,
                            'solution_composition' => $solutionComposition,
                            ],
                'properties' => $properties,
        ]);
    }
}
