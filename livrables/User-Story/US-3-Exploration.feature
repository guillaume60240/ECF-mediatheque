Feature: Exploration
    Scenario: En tant que membre je souhaite trouver un livre
        Given Je veux rechercher un livre par catégorie, auteur ou nom
        When J'utlise la navigation ou la barre de recherche 
        Then Je peux trouver mon livre et le réserver s'il est disponible
    