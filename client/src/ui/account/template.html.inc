<div class="flex flex-col gap-20">
    <p class="text-micromania-blue text-xl font-semibold">
        Bonjour <span id="username" class="text-black">{{client_name}}</span>
    </p>
    <div class="flex w-full gap-20">
        <div class="flex flex-col gap-12 self-stretch">
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
                <div id="orders" class="flex flex-col">
                    {{orders}}
                </div>
            </div>
        </div>
        <div class="flex flex-col gap-12 self-stretch max-h-96">
            <p class="text-micromania-blue text-xl font-semibold">Mon panier</p>
            <div id="cart" class="relative flex h-full overflow-hidden w-full">
                <div class="text-xl md:text-base absolute flex flex-col top-0 left-0 w-full h-full overflow-y-scroll">
                    {{products}}
                </div>
            </div>
        </div>
    </div>
</div>