<li 
  id="product-edit" 

  data-id_produits="{{id_produits}}" data-id_options="{{id_options}}"

  class="product flex justify-between flex-col items-left border-b border-gray-200 py-2"
>
  <p class="font-semibold">Produit #{{number}}</p>
  <p class="name font-semibold">Nom : {{name}} - {{short_name}}</p>
  <p class="price font-semibold">Prix: {{price}}</p>
  <label for="product-amount-{{id_produits}}-{{id_options}}">Quantité :</label>
  <input id="product-amount-{{id_produits}}-{{id_options}}" type="number" value={{quantity}}></input>
</li>
