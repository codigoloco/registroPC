<?php

namespace App\Http\Controllers;

use App\Models\Auditoria;
use App\Models\Cliente;
use App\Models\ContactoCliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ClienteController extends Controller
{
    /**
     * Muestra la lista de clientes paginada.
     */
    public function index()
    {
        $clientes = Cliente::orderBy('created_at', 'desc')->paginate(10);
        return view('gestion-clientes', compact('clientes'));
    }

    /**
     * Guarda un nuevo cliente y sus contactos.
     */
    public function saveCliente(Request $request)
    {
        $request->validate([
            'cedula' => 'required|integer|unique:clientes,id',
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'direccion' => 'required|string',
            'tipo_cliente' => 'required|in:natural,juridico,Gubernamental',
            'telefonos' => 'required|array',
            'telefonos.*' => 'required|string|max:50',
            'emails' => 'required|array',
            'emails.*' => 'required|email|max:150',
        ]);

        try {
            DB::beginTransaction();

            $cliente = Cliente::create([
                'id' => $request->cedula,
                'nombre' => $request->nombre,
                'apellido' => $request->apellido,
                'direccion' => $request->direccion,
                'tipo_cliente' => $request->tipo_cliente,
            ]);

            // Sincronizar contactos (asumiendo que telefonos y emails vienen en pares o manejarlos por separado)
            // Dado que la tabla contactos_clientes tiene telefono y correo en la misma fila, 
            // intentaremos emparejarlos si tienen el mismo tamaño, sino los guardaremos de forma independiente.
            $maxCount = max(count($request->telefonos), count($request->emails));

            for ($i = 0; $i < $maxCount; $i++) {
                ContactoCliente::create([
                    'id_cliente' => $cliente->id,
                    'telefono_cliente' => $request->telefonos[$i] ?? 'N/A',
                    'correo_cliente' => $request->emails[$i] ?? 'N/A',
                ]);
            }

            // Guardar auditoria
            Auditoria::create([
                'id_usuario' => Auth::id(),
                'id_caso' => null, // No aplica para cliente solo
                'sentencia' => 'INSERT_CLIENTE',
                'estado_final' => json_encode(['nota' => 'Cliente registrado.', 'datos' => $cliente->load('contactos')->toArray()]),
                'ip' => $request->ip(),
            ]);

            DB::commit();

            return redirect()->back()->with('success', 'Cliente registrado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error al registrar cliente: ' . $e->getMessage());
        }
    }

    /**
     * Actualiza un cliente existente.
     */
    public function updateCliente(Request $request)
    {
        $request->validate([
            'cedula' => 'required|integer|exists:clientes,id',
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'direccion' => 'required|string',
            'tipo_cliente' => 'required|in:natural,juridico,Gubernamental',
            'telefonos' => 'required|array',
            'emails' => 'required|array',
        ]);

        try {
            DB::beginTransaction();

            $cliente = Cliente::findOrFail($request->cedula);
            $estadoInicial = $cliente->load('contactos')->toArray();
            $cliente->update([
                'nombre' => $request->nombre,
                'apellido' => $request->apellido,
                'direccion' => $request->direccion,
                'tipo_cliente' => $request->tipo_cliente,
            ]);

            // Eliminar contactos antiguos y crear nuevos
            ContactoCliente::where('id_cliente', $cliente->id)->delete();

            $maxCount = max(count($request->telefonos), count($request->emails));

            for ($i = 0; $i < $maxCount; $i++) {
                ContactoCliente::create([
                    'id_cliente' => $cliente->id,
                    'telefono_cliente' => $request->telefonos[$i] ?? 'N/A',
                    'correo_cliente' => $request->emails[$i] ?? 'N/A',
                ]);
            }

            // Guardar auditoria
            Auditoria::create([
                'id_usuario' => Auth::id(),
                'id_caso' => null,
                'sentencia' => 'UPDATE_CLIENTE',
                'estado_inicial' => json_encode($estadoInicial),
                'estado_final' => json_encode($cliente->fresh()->load('contactos')->toArray()),
                'ip' => $request->ip(),
            ]);

            DB::commit();

            return redirect()->back()->with('success', 'Cliente actualizado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error al actualizar cliente: ' . $e->getMessage());
        }
    }

    /**
     * Busca un cliente por Cedula/RIF.
     */
    public function findById($id)
    {
        $cliente = Cliente::with('contactos')->find($id);

        if (!$cliente) {
            return response()->json(['error' => 'Cliente no encontrado'], 404);
        }

        return response()->json($cliente);
    }
}
