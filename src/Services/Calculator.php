<?php

namespace App\Services;

class Calculator
{
    // Constante pour la valeur de Pi
    const PI = 3.14159;

    /**
     * Calcule le metrage nécessaire pour une jupe cercle
     *
     * @param float $tourDeTaille Le tour de taille en centimètres
     * @param float $longueurJupe La longueur de la jupe en centimètres
     * @param float $metrageTissu Le metrage de tissu nécessaire (en cm)
     * @return float La quantité de tissu nécessaire (en cm)
     */
    public function calculateCircleSkirt(float $tourDeTaille, float $longueurJupe): float
    {
        // Calcul du rayon du cercle à partir du tour de taille
        $rayon = $tourDeTaille / (2 * self::PI);

        // Calcul de la quantité de tissu nécessaire
        $metrageTissu = $longueurJupe + ($rayon * 2);

        return $metrageTissu;
    }
}
