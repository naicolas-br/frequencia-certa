<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HorarioAula extends Model
{
    use HasFactory;

    /**
     * IMPORTANTE:
     * O Laravel tentaria buscar a tabela 'horario_aulas' (plural do nome da classe).
     * Como nossa migration criou 'grade_horarias', precisamos forçar esse nome aqui.
     */
    protected $table = 'grade_horarias';

    /**
     * O erro 'MassAssignmentException' aconteceu porque não listamos
     * aqui quais campos são seguros para serem salvos.
     */
    protected $fillable = [
        'user_id',       // Adicionei user_id caso precisemos filtrar por aluno direto
        'disciplina_id',
        'dia_semana',
        'horario_inicio',
        'horario_fim'
    ];

    // Relacionamento: Um horário pertence a uma Disciplina
    public function disciplina()
    {
        return $this->belongsTo(Disciplina::class);
    }
}