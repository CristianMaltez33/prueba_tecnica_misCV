<?php

namespace App\Http\Controllers;

use App\Helpers\HomePageHelper;
use App\Http\Requests\MisCv\SearchCvRequest;
use App\Queries\MisCvQueryBuilder;

class MisCvController extends Controller
{
    public function index(SearchCvRequest $request)
    {
        $params = $request->validated();

        $resultados = MisCvQueryBuilder::search($params)->get();

        $catalogos = HomePageHelper::getCatalogos();

        return view('home', array_merge($catalogos, [
            'resultados' => $resultados
        ]));
    }

    public function exportCsv(SearchCvRequest $request)
    {
        $params = array_filter($request->validated(), fn($v) => $v !== null && $v !== '');
        $cvs = MisCvQueryBuilder::search($params)->get();

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="cvs.csv"',
        ];

        $columns = ['Nombre', 'Correo', 'Teléfono', 'Departamento', 'Vehículo', 'Licencia', 'Salario más alto'];

        $callback = function () use ($cvs, $columns) {
            $file = fopen('php://output', 'w');

            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fwrite($file, implode(';', $columns) . "\n");

            foreach ($cvs as $cv) {
                $salarioMax = collect($cv->exlaboral)->pluck('salario')->map(fn($s) => (int)$s)->max();

                $row = [
                    $cv->nombre_completo,
                    $cv->correo,
                    $cv->telefono,
                    $cv->departamento,
                    $cv->vehiculo,
                    $cv->licencia,
                    $salarioMax
                ];

                fwrite($file, implode(';', $row) . "\n");
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportJson(SearchCvRequest $request)
    {
        $params = $request->validated();
        $cvs = MisCvQueryBuilder::search($params)->get();

        $data = $cvs->map(function ($cv) {
            return json_decode($cv, true);
        });

        return response()->json($data, 200, [
            'Content-Type' => 'application/json; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="cvs.json"',
        ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }
}
