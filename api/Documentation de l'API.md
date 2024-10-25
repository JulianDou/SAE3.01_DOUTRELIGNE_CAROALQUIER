# Documentation de l'API

Cette API permet de récupérer des informations sur des produits, des catégories, des options, et des clients.
https://chatgpt.com/share/671254c1-1070-8005-9991-7f734eb06a49

## Base URL
```
https://mmi.unilim.fr/~caroalquier1/SAE301/api
```

---

## Endpoints

### 1. Récupérer tous les produits sans leurs options

**Requête**  
`GET /products`

**Exemple de réponse**
```json
[
  {
    "id": 3,
    "name": "Manette de Xbox",
    "price": 61.99,
    "description": "Ceci est une manette de xbox classique",
    "image": "manette-microsoft-rouge.jpg",
    "retailer": "Microsoft"
  },
  {
    "id": 4,
    "name": "Manette de switch",
    "price": 69.99,
    "description": "Une manette pour la console de nintendo...",
    "image": "manette-nintendo-rouge.jpg",
    "retailer": "Nintendo"
  }
]
```

---

### 2. Récupérer toutes les catégories

**Requête**  
`GET /categories`

**Exemple de réponse**
```json
[
  {
    "id": 1,
    "name": "Manettes",
    "icone": "manettes.svg",
    "image": "manettes.jpg"
  },
  {
    "id": 2,
    "name": "Consoles",
    "icone": "consoles.svg",
    "image": "consoles.webp"
  },
  {
    "id": 3,
    "name": "Jeux-vidéo",
    "icone": "jeux-video.svg",
    "image": "jeux-video.jpg"
  }
]
```

---

### 3. Récupérer une catégorie spécifique

**Requête**  
`GET /categories/{id}`

**Exemple**  
`GET /categories/1`

**Exemple de réponse**
```json
{
  "id": 1,
  "name": "Manettes",
  "icone": "manettes.svg",
  "image": "manettes.jpg"
}
```

---

### 4. Récupérer tous les produits d'une catégorie

**Requête**  
`GET /products?category={id}`

**Exemple**  
`GET /products?category=1`

**Exemple de réponse**
```json
[
  {
    "id": 3,
    "name": "Manette de Xbox",
    "price": 61.99,
    "description": "Ceci est une manette de xbox classique",
    "image": "manette-microsoft-rouge.jpg",
    "retailer": "Microsoft"
  },
  {
    "id": 4,
    "name": "Manette de switch",
    "price": 69.99,
    "description": "Une manette pour la console de nintendo...",
    "image": "manette-nintendo-rouge.jpg",
    "retailer": "Nintendo"
  }
]
```

---

### 5. Récupérer toutes les options d'un produit

**Requête**  
`GET /products/{id}`

**Exemple**  
`GET /products/1`

**Exemple de réponse**
```json
{
  "id_product": 1,
  "options": [
    {
      "id_options": 3,
      "name": "Manette Xbox",
      "category": 1,
      "price": 59.99,
      "description": "Une superbe manette",
      "image": "https://img-prod-cms-rt-microsoft-com.akamaized.net/cms/api/am/imageFileData/RE4FlSK?ver=3eb6",
      "revendeur": "Microsoft"
    },
    {
      "id_options": 4,
      "name": "Manette Xbox Bleu",
      "category": 1,
      "price": 69.99,
      "description": "Une superbe manette",
      "image": "https://img-prod-cms-rt-microsoft-com.akamaized.net/cms/api/am/imageFileData/RE4FlSK?ver=3eb6",
      "revendeur": "Microsoft"
    }
  ]
}
```

---

### 6. Récupérer toutes les informations de tous les clients

**Requête**  
`GET /clients`

**Exemple de réponse**
```json
[
  {
    "id": 1,
    "name": "Julian",
    "email": "julian.dou@gmail.com",
    "password": "micromania2024"
  }
]
```

---

### 7. Renvoyer toutes les options d'un produit spécifique

**Requête**  
`GET /options/{id}`

**Exemple**  
`GET /options/3`

**Exemple de réponse**
```json
[
  {
    "id": 3,
    "id_options": 5,
    "name": "Manette de Xbox",
    "short_name": "Rouge",
    "price": 61.99,
    "description": "Ceci est une manette de xbox classique",
    "image": "manette-microsoft-rouge.jpg",
    "retailer": "Microsoft"
  },
  {
    "id": 3,
    "id_options": 6,
    "name": "Manette de Xbox",
    "short_name": "Bleue",
    "price": 59.99,
    "description": "Ceci est une manette de xbox classique",
    "image": "manette-microsoft-bleue.jpg",
    "retailer": "Microsoft"
  }
]
```

---

### 8. Renvoyer une option spécifique d'un produit

**Requête**  
`GET /options/{id}?option={option_id}`

**Exemple**  
`GET /options/3?option=6`

**Exemple de réponse**
```json
[
  {
    "id": 3,
    "id_options": 6,
    "name": "Manette de Xbox",
    "short_name": "Bleue",
    "price": 59.99,
    "description": "Ceci est une manette de xbox classique",
    "image": "manette-microsoft-bleue.jpg",
    "retailer": "Microsoft"
  }
]
```

---

### 9. Récupérer toutes les options de tous les produits

**Requête**  
`GET /options`

**Exemple de réponse**
```json
[
  {
    "id": 3,
    "id_options": 5,
    "name": "Manette de Xbox",
    "short_name": "Rouge",
    "price": 61.99,
    "description": "Ceci est une manette de xbox classque ",
    "image": "manette-microsoft-rouge.jpg",
    "retailer": "Microsoft"
  },
  {
    "id": 3,
    "id_options": 6,
    "name": "Manette de Xbox",
    "short_name": "Bleue",
    "price": 59.99,
    "description": "Ceci est une manette de xbox classque ",
    "image": "manette-microsoft-bleue.jpg",
    "retailer": "Microsoft"
  }
]
```
### 10. Récupérer toutes les commandes

**Requête**  
`GET /commandes`

**Exemple de réponse**
```json
[
  {
    "id_commandes": 1,
    "id_clients": 1,
    "date_commande": "2024-10-21 09:35:57",
    "statut": "disponible",
    "produits": [
      {
        "id_produits": 6,
        "quantite": 3,
        "prix": "19.99"
      }
    ]
  },
  {
    "id_commandes": 2,
    "id_clients": 1,
    "date_commande": "2024-10-21 09:35:57",
    "statut": "en_cours",
    "produits": [
      {
        "id_produits": 6,
        "quantite": 3,
        "prix": "19.99"
      },
      {
        "id_produits": 4,
        "quantite": 2,
        "prix": "59.99"
      }
    ]
  }
]
```


### 11. Récupérer une commande spécifique

**Requête**  
`GET /commandes/{id}`

**Exemple**  
`GET /commandes/1`

**Exemple de réponse**
```json
{
  "id_commandes": 1,
  "id_clients": 1,
  "date_commande": "2024-10-21 09:35:57",
  "statut": "disponible",
  "produits": [
    {
      "id_produits": 6,
      "quantite": 3,
      "prix": "19.99"
    }
  ]
}
```

---+-+-+-+-+