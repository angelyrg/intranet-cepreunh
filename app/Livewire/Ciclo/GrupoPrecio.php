<?php

namespace App\Livewire\Ciclo;

use App\Models\Intranet\Banco;
use App\Models\Intranet\Carrera;
use App\Models\Intranet\FormaDePago;
use App\Models\Intranet\GrupoPrecio as IntranetGrupoPrecio;
use App\Models\Intranet\Precio;
use App\Models\Intranet\Sede;
use Livewire\Component;

class GrupoPrecio extends Component
{
    public $cicloId;
    public $grupoPrecio = ['nombre' => ''];
    public $carrerasSeleccionadas = [];
    public $formasDePago;
    public $bancos;
    public $precios = [];
    public $carreras;
    
    public $sedes = [];
    public $sedeId;

    public $gruposPrecios;


    protected $listeners = ['asignacionCarreraActualizada' => 'actualizarDatos'];


    public function mount($cicloId)
    {
        $this->cicloId = $cicloId;
        $this->formasDePago = FormaDePago::all();
        $this->bancos = Banco::all();
        // $this->carreras = Carrera::all();
        $this->carreras = $this->getCarrerasDisponibles();
        $this->sedes = Sede::all();
        $this->precios = $this->initializePrecios();



        $this->gruposPrecios = IntranetGrupoPrecio::where('ciclo_id', $this->cicloId)
            ->with(['carreras', 'precios.banco', 'precios.forma_de_pago']) 
            ->get();
    }

    public function actualizarDatos(){
        $this->carreras = $this->getCarrerasDisponibles();
    }

    public function initializePrecios()
    {
        $precios = [];

        // Inicializa la estructura de precios
        foreach ($this->formasDePago as $formaDePago) {
            foreach ($this->bancos as $banco) {
                $precios[$formaDePago->id]['bancos'][$banco->id] = [
                    'monto' => 0,
                    'desasociado' => false
                ];
            }
        }

        return $precios;
    }

    public function crearGrupo()
    {
        // Validación de los campos
        $this->validate([
            'cicloId' => 'required',
            'sedeId' => 'required',
            'carrerasSeleccionadas' => 'required|array',
            'precios.*.bancos.*.monto' => 'required|numeric|min:0',
        ]);

        // Crear el grupo de precios
        $grupo = IntranetGrupoPrecio::create([
            'ciclo_id' => $this->cicloId,
            'sede_id' => $this->sedeId
        ]);

        // Asociar las carreras seleccionadas al grupo
        $grupo->carreras()->attach($this->carrerasSeleccionadas);

        // Guardar los precios para cada banco y forma de pago
        foreach ($this->precios as $formaDePagoId => $formaDePagoPrecios) {
            foreach ($formaDePagoPrecios['bancos'] as $bancoId => $precio) {
                // Solo guardar si el banco no está desasociado
                if (!$precio['desasociado'] && $precio['monto'] > 0) {
                    Precio::create([
                        'grupo_id' => $grupo->id,
                        'sede_id' => $this->sedeId,
                        'ciclo_id' => $this->cicloId,
                        'forma_de_pago_id' => $formaDePagoId,
                        'banco_id' => $bancoId,
                        'monto' => $precio['monto'],
                    ]);
                }
            }
        }
    }

    public function getCarrerasDisponibles()
    {
        return Carrera::whereHas('carrera_ciclo', function($query){
            $query->where('ciclo_id', $this->cicloId);
        })->whereDoesntHave('grupo_precios', function ($query) {
            $query->where('ciclo_id', $this->cicloId);
        })->get();
    }

    public function seleccionarTodas($seleccionar)
    {
        if ($seleccionar) {
            // Si se seleccionan todas, llenamos el array con todas las carreras
            $this->carrerasSeleccionadas = $this->carreras->pluck('id')->toArray();
        } else {
            // Si se desmarcan todas, vaciamos el array
            $this->carrerasSeleccionadas = [];
        }
    }

    public function render()
    {
        $this->mount($this->cicloId);
        return view('livewire.ciclo.grupo-precio');
    }
}
