<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateTriggerActualizarEtapaCrecimiento extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::unprepared("
            -- Trigger para INSERT
            CREATE TRIGGER actualizar_etapa_crecimiento_insert
            BEFORE INSERT ON vacas
            FOR EACH ROW
            BEGIN
                -- Calcular los meses de diferencia entre la fecha actual y la fecha de nacimiento
                SET NEW.etapa_de_crecimiento = CASE
                    WHEN TIMESTAMPDIFF(MONTH, NEW.fecha_nacimiento, CURDATE()) < 7 THEN 'cria'
                    WHEN TIMESTAMPDIFF(MONTH, NEW.fecha_nacimiento, CURDATE()) < 12 THEN 'ternero'
                    WHEN TIMESTAMPDIFF(MONTH, NEW.fecha_nacimiento, CURDATE()) < 15 THEN 'juvenil'
                    ELSE 'adulto'
                END;

                -- Si la vaca es adulta, marcarla como gestante
                IF NEW.etapa_de_crecimiento = 'adulto' THEN
                    SET NEW.estado_reproductivo = 'gestante';
                ELSE
                    SET NEW.estado_reproductivo = 'no gestante';
                END IF;
            END;

            -- Trigger para UPDATE
            CREATE TRIGGER actualizar_etapa_crecimiento_update
            BEFORE UPDATE ON vacas
            FOR EACH ROW
            BEGIN
                -- Calcular los meses de diferencia entre la fecha actual y la fecha de nacimiento
                SET NEW.etapa_de_crecimiento = CASE
                    WHEN TIMESTAMPDIFF(MONTH, NEW.fecha_nacimiento, CURDATE()) < 7 THEN 'cria'
                    WHEN TIMESTAMPDIFF(MONTH, NEW.fecha_nacimiento, CURDATE()) < 12 THEN 'ternero'
                    WHEN TIMESTAMPDIFF(MONTH, NEW.fecha_nacimiento, CURDATE()) < 15 THEN 'juvenil'
                    ELSE 'adulto'
                END;

                -- Si la vaca es adulta, marcarla como gestante
                IF NEW.etapa_de_crecimiento = 'adulto' THEN
                    SET NEW.estado_reproductivo = 'gestante';
                ELSE
                    SET NEW.estado_reproductivo = 'no gestante';
                END IF;
            END;
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("
            DROP TRIGGER IF EXISTS actualizar_etapa_crecimiento_insert;
            DROP TRIGGER IF EXISTS actualizar_etapa_crecimiento_update;
        ");
    }
}
