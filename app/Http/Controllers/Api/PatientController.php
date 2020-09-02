<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PatientRequest;
use App\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(['patients' => Patient::paginate(10)]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(PatientRequest $request)
    {
        Patient::create(
            [
                'name' => $request->name,
                'cpf' => $request->cpf,
                'cellphone' => $request->cellphone,
                'email' => $request->email
            ]
        );

        return response()->json('Cadastro realizado com sucesso', 201);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $patient = Patient::find($id);

        if (!$patient) {
            return response()->json("Paciente não encontrado", 404);
        }

        return response()->json($patient);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(PatientRequest $request, $id)
    {
        $patient = Patient::find($id);

        if ($patient != null) {
            $patient->name = $request->name;
            $patient->cpf = $request->cpf;
            $patient->cellphone = $request->cellphone;
            $patient->email = $request->email;
            $patient->save();
        } else {
            return response()->json("Paciente não encontrado", 404);
        }

        return response()->json('Atualização realizada com sucesso', 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $patient = Patient::find($id);

        if ($patient != null) {
            $patient->delete();
        } else {
            return response()->json("Paciente não encontrado", 404);
        }

        return response()->json("Paciente deletado com sucesso", 200);
    }
}
