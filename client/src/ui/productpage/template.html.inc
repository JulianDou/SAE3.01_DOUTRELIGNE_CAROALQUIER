<div class="flex w-full py-14 px-20 gap-3">
    <div class="flex flex-col gap-5 w-full min-w-96">
        <div class="flex flex-col gap-3 items-start">
            <h2 class="text-micromania-blue font-semibold text-2xl">
                {{name}}
            </h2>
            <p class="text-generic-grey text-xl">
                {{retailer}}
            </p>
        </div>
        <div class="flex justify-center items-center py-3 px-5">
            <img src="./src/assets/{{image}}" alt="{{name}}" class="object-contain h-full">
        </div>
    </div>
    <div class="pt-6 flex flex-col gap-7 max-w-96">
        <div class="flex flex-col gap-3">
            <p class="text-sm"><span class="font-semibold">Option : </span>{{short_name}}</p>
            <div class="flex gap-3 flex-wrap">
                {{options}}
            </div>
        </div>
        <p class="text-generic-grey font-light">
            {{description}}
        </p>
        <div class="flex flex-col justify-end gap-7">
            <div class="flex items-end">
                <p class="text-2xl font-bold">{{price}}</p>
                <p class="font-medium">€</p>
            </div>
            <div>
                <!-- mettre le stock/magasin ici -->
            </div>
            <div class="flex w-full justify-center rounded-md bg-micromania-blue py-6 hover:cursor-pointer hover:bg-micromania-darkblue">
                <p class="text-white">Ajouter au panier</p>
            </div>
        </div>
    </div>
</div>