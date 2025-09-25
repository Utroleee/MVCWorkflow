<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!Auth::user()->hasRole('Administrador') && 
                !Auth::user()->hasRole('Técnico') && 
                !Auth::user()->hasRole('Cliente')) {
                abort(403, 'No tienes permiso para acceder a esta sección.');
            }
            return $next($request);
        });
    }

    /**
     * Muestra el formulario para crear un nuevo ticket.
     */
    public function create()
    {
        if (!Auth::user()->hasRole('Cliente')) {
            abort(403, 'Solo los clientes pueden crear tickets.');
        }
        return view('tickets.create');
    }

    /**
     * Almacena un nuevo ticket en la base de datos.
     */
    public function store(Request $request)
    {
        if (!Auth::user()->hasRole('Cliente')) {
            abort(403, 'Solo los clientes pueden crear tickets.');
        }

        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'prioridad' => 'required|in:Alta,Media,Baja',
            'categoria' => 'required|string|max:255',
        ]);

        $ticket = Ticket::create([
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'prioridad' => $request->prioridad,
            'categoria' => $request->categoria,
            'cliente_id' => Auth::id(),
            'estado' => 'Abierto',
        ]);

        return redirect()->route('tickets.show', $ticket)
            ->with('success', 'Ticket creado exitosamente.');
    }

    /**
     * Muestra los detalles de un ticket específico.
     */
    public function show(Ticket $ticket)
    {
        $user = Auth::user();
        
        if (!$user->hasRole('Administrador') && 
            $user->id !== $ticket->cliente_id && 
            $user->id !== $ticket->tecnico_id) {
            abort(403, 'No tienes permiso para ver este ticket.');
        }

        $tecnicos = User::whereHas('roles', function($query) {
            $query->where('name', 'Técnico');
        })->get();
        
        return view('tickets.show', compact('ticket', 'tecnicos'));
    }

    /**
     * Lista todos los tickets según el rol del usuario.
     */
    public function index()
    {
        $user = Auth::user();
        $tickets = [];

        if ($user->hasRole('Administrador')) {
            $tickets = Ticket::with(['cliente', 'tecnico'])->latest()->get();
        } elseif ($user->hasRole('Técnico')) {
            $tickets = Ticket::where('tecnico_id', $user->id)
                ->with(['cliente'])
                ->latest()
                ->get();
        } else {
            $tickets = Ticket::where('cliente_id', $user->id)
                ->with(['tecnico'])
                ->latest()
                ->get();
        }

        return view('tickets.index', compact('tickets'));
    }

    /**
     * Actualiza el estado de un ticket.
     */
    public function updateStatus(Request $request, Ticket $ticket)
    {
        $user = Auth::user();
        
        if (!$user->hasRole('Administrador') && $user->id !== $ticket->tecnico_id) {
            abort(403, 'No tienes permiso para actualizar el estado de este ticket.');
        }

        $request->validate([
            'estado' => 'required|in:Abierto,Asignado,En espera,Resuelto,Cerrado',
        ]);

        $ticket->update(['estado' => $request->estado]);

        return redirect()->back()
            ->with('success', 'Estado del ticket actualizado.');
    }

    /**
     * Asigna un técnico a un ticket.
     */
    public function assignTechnician(Request $request, Ticket $ticket)
    {
        if (!Auth::user()->hasRole('Administrador')) {
            abort(403, 'Solo los administradores pueden asignar técnicos.');
        }

        $request->validate([
            'tecnico_id' => 'required|exists:users,id',
        ]);

        $ticket->update([
            'tecnico_id' => $request->tecnico_id,
            'estado' => 'Asignado',
        ]);

        return redirect()->back()
            ->with('success', 'Técnico asignado exitosamente.');
    }

    /**
     * Elimina un ticket.
     */
    public function destroy(Ticket $ticket)
    {
        $user = Auth::user();
        
        if (!$user->hasRole('Administrador') && $user->id !== $ticket->cliente_id) {
            abort(403, 'No tienes permiso para eliminar este ticket.');
        }

        $ticket->delete();

        return redirect()->route('tickets.index')
            ->with('success', 'Ticket eliminado exitosamente.');
    }
}