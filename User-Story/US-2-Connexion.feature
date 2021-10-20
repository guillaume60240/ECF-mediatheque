Feature: Connexion
    Scenario: En tant que membre je souhaite parcourir le catalogue
        Given J'ai besoin de me connecter 
        When Je remplis le formulaire de connexion
        Then Je peux accéder au catalogue et à mon compte
    Scenario: En tant qu'employé je souhaite parcourir le catalogue ou accéder à l'espace d'administration
        Given J'ai besoin de me connecter 
        When Je remplis le formulaire de connexion 
        Then Je peux accéder au catalogue, à mon compte et à l'espace d'administration
    

    