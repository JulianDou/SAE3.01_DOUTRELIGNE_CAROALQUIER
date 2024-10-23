<div class="flex p-3 gap-3 w-full border-4 bg-white">
    <div class="flex flex-col gap-2 h-fit w-full">
        {{product_list}}
    </div>
    <div class="flex flex-col gap-2 h-full min-w-52">
        <p class="font-semibold text-micromania-blue">Date : <span id="order-date" class="font-normal text-black">{{order_date}}</span></p>
        <p class="font-semibold text-micromania-blue">Statut : <span id="order-status" class="font-normal text-black">{{order_status}}</span></p>
        <div class="flex flex-col gap-2">
            <p class="font-semibold text-micromania-blue">Total de la commande :</p>
            <p><span id="order-total" class="text-2xl">{{total}}</span>€</p>
        </div>
        <div class="flex flex-col justify-end h-full">
            <p class="text-generic-grey"></p>
            <div id="order-cancel" class="flex items-center justify-center text-lg md:text-base w-full py-2 bg-red-500 hover:cursor-pointer hover:bg-red-600 text-white text-center text-nowrap whitespace-nowrap rounded-md">
                Annuler ma commande
            </div>
        </div>
    </div>
</div>