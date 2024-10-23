<div class="flex flex-col gap-20 pt-16 px-20">
    <p class="text-micromania-blue text-xl font-semibold">
        Bonjour <span id="username" class="text-black">{{name}}</span>
    </p>
    <div class="flex w-full gap-20">
        <div class="flex flex-col gap-12 w-full">
            <p class="text-micromania-blue text-xl font-semibold">Mes commandes</p>
            <div class="flex flex-col gap-6">
                <p class="text-micromania-blue text-lg">
                    Votre dernière commande
                </p>
                <div id="last-order" class="flex flex-col">
                    {{lastorder}}
                </div>
            </div>
            <div class="flex flex-col gap-6">
                <p class="text-micromania-blue text-lg">
                    Plus tôt
                </p>
                <div id="orders" class="flex flex-col gap-3">
                    {{orders}}
                </div>
            </div>
        </div>
        <div class="flex flex-col gap-12 w-full max-h-96">
            <p class="text-micromania-blue text-xl font-semibold">Mon panier</p>
            <div id="account-cart" class="text-xl md:text-base flex flex-col w-full gap-3">
                {{products}}
            </div>
        </div>
    </div>
</div>