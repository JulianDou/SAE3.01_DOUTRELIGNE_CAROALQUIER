<div id="product-card" dataset-product_id="{{id}}" class="flex flex-col p-5 gap-5 bg-white w-60 flex-grow-0 shadow-xl transition-all hover:cursor-pointer hover:transition-all hover:border-micromania-blue border-4">
    <div class="h-44 flex justify-center items-center">
        <img id="product-img" src="./src/assets/{{image}}" alt="{{name}}" class="object-contain">
    </div>
    <div class="flex flex-col gap-2">
        <div class="flex flex-col gap-2">
            <p id="product-name" class="text-micromania-blue text-sm font-semibold">
                {{name}}
            </p>
            <p id="product-retailer" class="text-generic-grey text-sm">
                {{retailer}}
            </p>
        </div>
        <div class="flex justify-between items-end">
            <div class="bg-micromania-blue text-white font-medium px-5 py-2 h-fit rounded-lg flex-grow-0">
                Acheter
            </div>
            <div class="flex flex-col py-1 gap-4 items-end h-20">
                <div class="flex items-end">
                    <p id="product-price" class="text-2xl font-bold">{{price}}</p>
                    <p class="font-medium">€</p>
                </div>
            </div>
        </div>
    </div>
</div>