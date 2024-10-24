<div class="flex flex-col md:flex-row w-full py-6 px-10 md:py-14 md:px-64 gap-3">
    <div class="flex flex-col gap-5 w-full md:min-w-64 md:align-stretch">
        <div class="flex flex-col gap-3 items-start">
            <h2 class="text-micromania-blue font-semibold text-2xl">
                {{name}}
            </h2>
            <p class="text-generic-grey text-xl">
                {{retailer}}
            </p>
        </div>
        <div class="flex justify-center items-center py-3 px-5 md:h-full md:align-stretch">
            <img src="./src/assets/{{image}}" alt="{{name}}" class="object-contain align-stretch md:h-full max-h-96">
        </div>
    </div>
    <div class="pt-6 flex flex-col gap-7 md:max-w-96">
        <div class="flex flex-col gap-3">
            <p class="text-lg md:text-sm"><span class="font-semibold">Option : </span>{{short_name}}</p>
            <div class="flex w-full gap-3 overflow-x-scroll md:flex-wrap md:overflow-hidden">
                {{options}}
            </div>
        </div>
        <p class="text-generic-grey text-lg md:text-base font-light">
            {{description}}
        </p>
        <div class="flex flex-col justify-end gap-7">
            <div class="flex items-end">
                <p class="text-3xl md:text-2xl font-bold">{{price}}</p>
                <p class="text-xl md:text-base font-medium">€</p>
            </div>
            <div>
                <!-- mettre le stock/magasin ici -->
            </div>
            <div id="product-buy" data-productid="{{id}}" data-optionid="{{id_options}}" class="flex w-full justify-center rounded-md bg-micromania-blue py-6 hover:cursor-pointer hover:bg-micromania-darkblue text-white">
                Ajouter au panier
            </div>
        </div>
    </div>
</div>