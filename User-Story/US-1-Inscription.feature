Feature: Inscription
    Scenario: En tant qu'utilisateur je souhaite devenir membre pour parcourir le catalogue
        Given J'ai besoin de m'enregistrer 
        When Je remplis le formulaire d'inscription
        Then Je peux valider mon mail avec le code reçu
    Scenario: En tant qu'employé je vois un inscrit non validé
        Given Son dossier est complet 
        When Je peux valider le compte de l'utilisateur 
        Then L'utilisateur est averti et peut parcourir le catalogue
    Scenario: En tant qu'employé je vois un inscrit non validé
        Given Son dossier n'est pas complet 
        When Je ne valide pas le compte de l'utilisateur 
        Then L'utilisateur ne peux pas parcourir le catalogue

    