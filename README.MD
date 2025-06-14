# Gestion des Stocks et des Ventes

Bienvenue dans le projet de **Gestion des Stocks et des Ventes** ! Cette application, développée avec **Phalcon PHP**, a pour objectif de rationaliser la gestion des stocks et des ventes pour les entreprises, en offrant une interface intuitive et des fonctionnalités adaptées à chaque type d'utilisateur.

## Table des Matières

- [Gestion des Stocks et des Ventes](#gestion-des-stocks-et-des-ventes)
  - [Table des Matières](#table-des-matières)
  - [Fonctionnalités](#fonctionnalités)
  - [Types d'Utilisateurs](#types-dutilisateurs)
  - [Technologies Utilisées](#technologies-utilisées)
  - [Installation](#installation)

## Fonctionnalités

- **Gestion des Utilisateurs** : Création et gestion des comptes utilisateurs.
- **Consultation du Stock** : Vérification de la disponibilité des produits.
- **Gestion des Approvisionnements** : CRUD sur les produits, fournisseurs et catégories.
- **Tableaux de Bord Personnalisés** : Interfaces adaptées aux rôles des utilisateurs.

## Types d'Utilisateurs

1. **Admin**
   - Accès complet au système.
   - Gestion des comptes utilisateurs (vendeurs, magasiniers, etc.).
   - Consultation, modification et suppression des données.

2. **Vendeur**
   - S'occupe uniquement des ventes.
   - Consultation du stock avant de vendre un produit.
   - Accès en lecture aux fiches produits (prix, quantité disponible).

3. **Magasinier**
   - Gestion des approvisionnements, produits et stocks.
   - Opérations CRUD sur les entités.
   - Mise à jour des quantités en stock lors des approvisionnements.

## Technologies Utilisées

- **Langage** : PHP
- **Framework** : Phalcon PHP
- **Base de Données** : MySQL
- **Outils** : Git, Composer

## Installation

Pour cloner ce projet, exécutez la commande suivante :

```bash
git clone https://github.com/masango2001/gestion-stocks-ventes.git