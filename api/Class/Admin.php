<?php
/**
 *  Class Admin
 * 
 *  Représente un administrateur avec des propriétés (id, nom, email, mot_de_passe)
 * 
 *  Implémente l'interface JsonSerializable 
 *  qui oblige à définir une méthode jsonSerialize. Cette méthode permet de dire comment les objets
 *  de la classe Admin doivent être converti en JSON. Voire la méthode pour plus de détails.
 */
class Admin implements JsonSerializable {
    private int $id_admin; // id de l'administrateur
    private string $nom; // nom de l'administrateur
    private string $email; // email de l'administrateur
    private string $mot_de_passe; // mot de passe de l'administrateur
    private bool $isAuth = false; // indique si l'administrateur est connecté

    public function isAuth(): bool {
        return $this->isAuth;
    }

    public function setAuth(bool $isAuth): self {
        $this->isAuth = $isAuth;
        return $this;
    }

    public function __construct(int $id_admin, string $nom = '', string $email = '', string $mot_de_passe = ''){
        $this->id_admin = $id_admin;
        $this->nom = $nom;
        $this->email = $email;
        $this->mot_de_passe = $mot_de_passe;
    }

    public function JsonSerialize(): mixed {
        $json = [
            "id" => $this->id_admin,
            "name" => $this->nom,
            "email" => $this->email,
            "password" => $this->mot_de_passe
        ];

        return $json;
    }

    public function setId(int $id): self {
        $this->id_admin = $id;
        return $this;
    }

    public function getId(): int {
        return $this->id_admin;
    }

    public function getName(): string {
        return $this->nom;
    }

    public function setName(string $name): self {
        $this->nom = $name;
        return $this;
    }

    public function getPassword(): string {
        return $this->mot_de_passe;
    }

    public function setPassword(string $mot_de_passe): self {
        $this->mot_de_passe = $mot_de_passe;
        return $this;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function setEmail(string $email): self {
        $this->email = $email;
        return $this;
    }
}
