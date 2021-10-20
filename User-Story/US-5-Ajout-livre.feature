Feature: Ajouter un livre
    Scenario: En tant qu'employé je souhaite ajouter un livre
        Given J'ai accés à l'interface d'administration
        When Je renseigne les informations nécessaires (titre, auteur, date de parution, catégorie, résumé, image)
        Then Je peux enregistrer le livre au catalogue