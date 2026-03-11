<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentsController extends Controller
{
    public function index()
    {
        $payments = Payment::all();

        return view('payments.list', compact('payments'));
    }

    public function create()
    {
        return view('payments.create');
    }

    public function store(Request $request)
    {
        $mensajes = [
            'description.required' => 'El campo descripción es requerido',
            'description.string' => 'El campo descripción debe ser una cadena de texto',
            'description.max' => 'El campo descripción no puede exceder los 255 caracteres',
            'price.required' => 'El campo precio es requerido',
            'price.integer' => 'El campo precio debe ser un número entero',
        ];

        $request->validate([
            'description' => 'required|string|max:255',
            'price' => 'required|integer',
        ], $mensajes);

        Payment::create($request->all());

        return redirect()->route('payments')->with('alert-success', 'Pago subido exitosamente.');
    }

    public function edit($id)
    {
        $payment = Payment::findOrFail($id);

        return view('payments.edit', compact('payment'));
    }

    public function update(Request $request, $id)
    {
        $mensajes = [
            'description.required' => 'El campo descripción es requerido',
            'description.string' => 'El campo descripción debe ser una cadena de texto',
            'description.max' => 'El campo descripción no puede exceder los 255 caracteres',
            'price.required' => 'El campo precio es requerido',
            'price.integer' => 'El campo precio debe ser un número entero',
        ];

        $request->validate([
            'description' => 'required|string|max:255',
            'price' => 'required|integer',
        ], $mensajes);

        $payment = Payment::findOrFail($id);

        $request->validate([
            'description' => 'required|string|max:255',
            'price' => 'required|integer',
        ]);

        $payment->update($request->all());

        return redirect()->route('payments')->with('alert-success', 'Pago actualizado exitosamente');
    }

    public function destroy($id)
    {
        //validar si existe registro
        if(!Payment::where('id', $id)->exists()){
            return redirect()->route('payments')->with('alert-error', 'Pago no fue encontrado');
        }

        $payment = Payment::findOrFail($id);
        $payment->delete();

        return redirect()->route('payments')->with('alert-success', 'Pago eliminado exitosamente');
    }

    public function getPayments()
    {
        $payments = Payment::all();

        return datatables()->of($payments)
            ->addColumn('action', function ($payment) {
                $editBtn = '<a href="' . route('payments-edit', $payment->id) . '" class="btn btn-sm btn-warning">Editar</a>';
                $deleteForm = '<form action="' . route('payments-destroy', $payment->id) . '" method="POST" style="display:inline-block">' .
                    csrf_field() .
                    method_field('DELETE') .
                    '<button type="submit" class="btn btn-sm btn-danger">Eliminar</button>' .
                    '</form>';
                return $editBtn.' '.$deleteForm;
            })->make(true);
    }

}