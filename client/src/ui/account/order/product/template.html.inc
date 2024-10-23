<div class="flex p-5 gap-5 w-full md:w-[28rem] bg-white flex-grow-0">
    <div class="w-20 h-20 flex justify-center items-center">
        <img src="./src/assets/{{image}}" alt="{{name}}" class="object-contain h-full">
    </div>
    <div class="flex flex-col justify-between w-full">
        <div class="flex flex-col gap-1">
            <p class="text-micromania-blue font-semibold">
                {{name}} - {{short_name}}
            </p>
            <p class="text-generic-grey">
                {{retailer}}
            </p>
        </div>
        <div class="flex flex-col justify-end">
            <p>Quantité : {{quantity}}</p>
        </div>
    </div>
</div>