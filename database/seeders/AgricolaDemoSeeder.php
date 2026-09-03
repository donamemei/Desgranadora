<?php

namespace Database\Seeders;

use App\Models\Alerta;
use App\Models\Clasificacion;
use App\Models\Lote;
use App\Models\Productor;
use App\Models\TipoMaiz;
use App\Models\User;
use Illuminate\Database\Seeder;

class AgricolaDemoSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@desgranadora.com'],
            ['name' => 'Administrador', 'password' => bcrypt('admin1234'), 'rol' => 'administrador']
        );

        $productores = [
            ['nombre' => 'Luis', 'apellido' => 'Márquez', 'cedula' => '12345678', 'telefono' => '0414-1234567', 'direccion' => 'Sector La Vega', 'municipio' => 'Ucureña'],
            ['nombre' => 'María', 'apellido' => 'Pérez', 'cedula' => '23456789', 'telefono' => '0416-7654321', 'direccion' => 'Calle Principal', 'municipio' => 'Ucureña'],
            ['nombre' => 'José', 'apellido' => 'Rojas', 'cedula' => '34567890', 'telefono' => '0424-9876543', 'direccion' => 'Zona Centro', 'municipio' => 'Ucureña'],
        ];

        foreach ($productores as $p) {
            Productor::updateOrCreate(['cedula' => $p['cedula']], $p);
        }

        $tipos = [
            ['nombre' => 'Maíz Blanco', 'descripcion' => 'Tipo tradicional para consumo y secado', 'categoria' => 'blanco'],
            ['nombre' => 'Maíz Amarillo', 'descripcion' => 'Uso industrial y producción de harina', 'categoria' => 'amarillo'],
            ['nombre' => 'Maíz Criollo', 'descripcion' => 'Variedad local con alto valor regional', 'categoria' => 'criollo'],
            ['nombre' => 'Maíz Híbrido', 'descripcion' => 'Variedad mejorada para rendimiento', 'categoria' => 'hibrido'],
        ];

        foreach ($tipos as $tipo) {
            TipoMaiz::updateOrCreate(['nombre' => $tipo['nombre']], $tipo);
        }

        $productorA = Productor::first();
        $productorB = Productor::skip(1)->first();
        $tipoA = TipoMaiz::first();
        $tipoB = TipoMaiz::skip(1)->first();

        $lote1 = Lote::firstOrCreate(
            ['sesion_id' => 'SES-UC-001'],
            [
                'productor_id' => $productorA->id,
                'tipo_maiz_id' => $tipoA->id,
                'fecha_recepcion' => now()->subDays(2)->toDateString(),
                'cantidad_kg' => 750,
                'observaciones' => 'Recepción con buen estado inicial.',
                'estado' => 'procesado',
            ]
        );

        $lote2 = Lote::firstOrCreate(
            ['sesion_id' => 'SES-UC-002'],
            [
                'productor_id' => $productorB->id,
                'tipo_maiz_id' => $tipoB->id,
                'fecha_recepcion' => now()->subDay()->toDateString(),
                'cantidad_kg' => 620,
                'observaciones' => 'Se observa humedad leve.',
                'estado' => 'alerta',
            ]
        );

        Clasificacion::firstOrCreate(
            ['lote_id' => $lote1->id],
            [
                'categoria' => 'primera',
                'porcentaje_primera' => 78.5,
                'porcentaje_segunda' => 15.0,
                'porcentaje_desechos' => 6.5,
                'observaciones' => 'Calidad aceptable para comercialización.',
                'usuario_id' => $admin->id,
            ]
        );

        Clasificacion::firstOrCreate(
            ['lote_id' => $lote2->id],
            [
                'categoria' => 'segunda',
                'porcentaje_primera' => 58.0,
                'porcentaje_segunda' => 30.0,
                'porcentaje_desechos' => 12.0,
                'observaciones' => 'Requiere revisión adicional de secado.',
                'usuario_id' => $admin->id,
            ]
        );

        Alerta::firstOrCreate(
            ['lote_id' => $lote2->id, 'tipo_alerta' => 'humedad'],
            [
                'mensaje' => 'El lote presenta humedad por encima del rango recomendado.',
                'nivel' => 'alta',
                'leida' => false,
            ]
        );

        Alerta::firstOrCreate(
            ['lote_id' => $lote1->id, 'tipo_alerta' => 'clasificacion'],
            [
                'mensaje' => 'La clasificación final fue aprobada con observaciones menores.',
                'nivel' => 'media',
                'leida' => true,
            ]
        );

        $this->command->info('Datos demo del módulo agrícola creados correctamente.');
    }
}
