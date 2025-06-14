<?php

namespace App\Enums;

enum TaskStatus: string
{
    case PENDIENTE = 'pendiente';
    case COMPLETADO = 'completada';
    case CANCELADO = 'cancelada';
}