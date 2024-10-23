<div id="cart-product-{{id}}-{{id_options}}" class="flex p-5 gap-5 w-full md:w-[28rem] border-4 bg-white flex-grow-0">
    <div class="w-20 h-32 flex justify-center items-center">
        <img src="./src/assets/{{image}}" alt="{{name}}" class="object-contain h-full">
    </div>
    <div class="flex flex-col justify-between w-full">
        <div class="flex flex-col gap-2">
            <p class="text-micromania-blue font-semibold">
                {{name}} - {{short_name}}
            </p>
            <p class="text-generic-grey">
                {{retailer}}
            </p>
        </div>
        <div class="flex w-full justify-between items-end">
            <div class="flex items-end">
                <p class="text-2xl font-bold">{{price}}</p>
                <p class="text-xl font-medium">€</p>
            </div>
        </div>
    </div>
</div>