Feature: Emprunter
    Scenario: En tant que membre je souhaite réserver un livre
        Given J'ai trouvé un livre que je veux emprunter
        When Je clique sur le bouton réserver
        Then Je peux l'ajouter à ma liste de réservation s'il est disponible
    Scenario: En tant que membre je souhaite emprunter un livre
        Given J'ai réservé un livre
        When Je me rends à la médiathèque sous 3 jours
        Then J'emprunte le livre pour une durée de 3 semaines
    Scenario: En tant qu'employé un utilisateur vient chercher un livre
        Given Je peux consulter les réservations en cours
        When La réservation est toujours valable
        Then Je valide la réservation et donne le livre à l'utilisateur