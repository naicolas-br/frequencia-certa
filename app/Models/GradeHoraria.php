<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GradeHoraria extends Model
{
    use HasFactory;

    // Força o Laravel a usar a tabela que já existe no banco
    protected $table = 'grade_horarias';

    protected $fillable = [
        'user_id',
        'disciplina_id',
        'dia_semana',   // 1 = Segunda, 2 = Terça...
        'horario_inicio',
        'horario_fim',
    ];

    // Helper para traduzir o número do dia para texto na tela
    public function getDiaSemanaTextoAttribute()
    {
        $dias = [
            1 => 'Segunda-feira',
            2 => 'Terça-feira',
            3 => 'Quarta-feira',
            4 => 'Quinta-feira',
            5 => 'Sexta-feira',
            6 => 'Sábado',
            7 => 'Domingo',
        ];

        return $dias[$this->dia_semana] ?? 'Desconhecido';
    }

    public function disciplina()
    {
        return $this->belongsTo(Disciplina::class);
    }
}