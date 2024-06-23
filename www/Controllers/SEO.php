<?php
namespace App\Controllers;

class SEO{
    function calculateSEO($content, $targetKeywords) {
        $score = 0;
        return $score;
    }
    
    function getSEOSuggestions($seoScore) {
        $suggestions = [];
        if ($seoScore < 0.5) {
            $suggestions[] = "Améliorer la densité de mots-clés (viser entre 0.2 et 0.5).";
            $suggestions[] = "Étendre le contenu pour atteindre au moins 300 mots.";
            $suggestions[] = "Inclure les mots-clés dans le titre et la méta description.";
        } else if ($seoScore >= 0.8) {
            $suggestions[] = "Continuer à optimiser le contenu pour améliorer encore le référencement.";
            $suggestions[] = "Suivre les tendances SEO et les bonnes pratiques pour maintenir un bon classement.";
        }
        return $suggestions;
    }
}