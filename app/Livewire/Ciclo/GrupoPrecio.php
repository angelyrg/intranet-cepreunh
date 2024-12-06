<?php

namespace App\Livewire\Ciclo;

use App\Models\Intranet\Banco;
use App\Models\Intranet\Carrera;
use App\Models\Intranet\FormaDePago;
use App\Models\Intranet\GrupoPrecio as IntranetGrupoPrecio;
use App\Models\Intranet\Precio;
// use App\Models\Intranet\GrupoPrecio;  // Asegúrate de importar GrupoPrecio
use Livewire\Component;

class GrupoPrecio extends Component
{
    public $cicloId;
    public $grupoPrecio = ['nombre' => ''];
    public $carrerasSeleccionadas = [];
    public $formasDePago;
    public $bancos;
    public $precios = [];

    public function mount($cicloId)
    {
        $this->cicloId = $cicloId;
        $this->formasDePago = FormaDePago::all();
        $this->bancos = Banco::all();
        $this->precios = $this->initializePrecios();
    }

    /**
     * Inicializa la estructura de precios con bancos asociados por defecto.
     * Los bancos estarán asociados y con monto igual a 0, pero se podrán cambiar.
     */
    public function initializePrecios()
    {
        $precios = [];

        // Inicializa la estructura de precios
        foreach ($this->formasDePago as $formaDePago) {
            foreach ($this->bancos as $banco) {
                $precios[$formaDePago->id]['bancos'][$banco->id] = [
                    'monto' => 0,            // Monto inicial
                    'desasociado' => false   // Desasociado por defecto
                ];
            }
        }

        return $precios;
    }

    public function crearGrupo()
    {
        // Validación de los campos
        $this->validate([
            'grupoPrecio.nombre' => 'required|string|max:255',
            'carrerasSeleccionadas' => 'required|array',
            'precios.*.bancos.*.monto' => 'required|numeric|min:0',
        ]);

        // Crear el grupo de precios
        $grupo = IntranetGrupoPrecio::create([
            'nombre' => $this->grupoPrecio['nombre'],
        ]);
        
        // Asociar las carreras seleccionadas al grupo
        $grupo->carreras()->attach($this->carrerasSeleccionadas);

        // Guardar los precios para cada banco y forma de pago
        foreach ($this->precios as $formaDePagoId => $formaDePagoPrecios) {
            foreach ($formaDePagoPrecios['bancos'] as $bancoId => $precio) {
                // Solo guardar si el banco no está desasociado
                if (!$precio['desasociado']) {
                    Precio::create([
                        'grupo_id' => $grupo->id,
                        'forma_de_pago_id' => $formaDePagoId,
                        'banco_id' => $bancoId,
                        'monto' => $precio['monto'],
                    ]);
                }
            }
        }

        // Mensaje de éxito
        session()->flash('message', 'Grupo de precios creado con éxito.');
        return redirect()->route('grupos_precios.index');
    }

    public function render()
    {
        // Obtener todas las carreras
        $carreras = Carrera::all();
        return view('livewire.ciclo.grupo-precio', compact('carreras'));
    }
}
