
    <li class="commande border border-gray-300 rounded-lg p-4 w-96">
      <div class="flex flex-row gap-2">
        <p class="text-micromania-blue font-semibold">
          Commande <span class="text-black">#{{id_commandes}}</span>
        </p>
        <p class="text-micromania-blue font-semibold">
          Date: <span class="text-black">{{order_date}}</span>
        </p>
      </div>
      <div class="client">
        <p class="text-micromania-blue font-semibold">
          Client: <span class="text-black">{{client_name}}</span>
        </p>
        <p class="text-micromania-blue font-semibold">
          Email: <span class="text-black">{{client_email}}</span>
        </p>
      </div>
      {{select_status}}
      <div id="edit-order" data-orderid={{id_commandes}} class="my-2 text-white text-center w-full py-2 bg-micromania-blue rounded hover:cursor-pointer hover:bg-micromania-darkblue">Modifier cette commande</div>
      <ul class="products__list">
        {{product_list}}
      </ul>
    </li>