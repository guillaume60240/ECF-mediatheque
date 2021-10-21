Feature: Restitution
    Scenario: En tant qu'employé je récupère un livre qu'un membre me rend
        Given Je peux accéder à la fiche de l'emprunt  
        When Je clique sur le bouton rendu pour valider la restitution  
        Then Le livre est de nouveau disponible 