<?php
/**
 *  Class Client
 * 
 *  Représente un client avec des propriétés (id, nom, email, mot_de_passe)
 * 
 *  Implémente l'interface JsonSerializable 
 *  qui oblige à définir une méthode jsonSerialize. Cette méthode permet de dire comment les objets
 *  de la classe Client doivent être converti en JSON. Voire la méthode pour plus de détails.
 */
class Client implements JsonSerializable {
    private int $id_clients; // id du client
    private string $nom; // nom du client
    private string $email; // email du client
    private string $mot_de_passe; // mot de passe du client
    private bool $isAuth = false; // indique si le client est connecté

    public function isAuth(): bool {
        return $this->isAuth;
    }

    public function setAuth(bool $isAuth): self {
        $this->isAuth = $isAuth;
        return $this;
    }

    public function __construct(int $id_clients, string $nom = '', string $email = '', string $mot_de_passe = ''){
        $this->id_clients = $id_clients;
        $this->nom = $nom;
        $this->email = $email;
        $this->mot_de_passe = $mot_de_passe;
    }

    public function JsonSerialize() {
        $json = [
            "id" => $this->id_clients,
            "name" => $this->nom,
            "email" => $this->email,
            "password" => $this->mot_de_passe
        ];

        return $json;
    }

    public function setId(int $id): self {
        $this->id_clients = $id;
        return $this;
    }

    public function getId(): int {
        return $this->id_clients;
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
