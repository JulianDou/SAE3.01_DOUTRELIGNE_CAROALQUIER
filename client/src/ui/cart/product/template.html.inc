<div id="cart-product-{{id}}-{{id_options}}" data-productid="{{id}}" data-optionid="{{id_options}}" class="relative flex p-5 gap-5 w-full md:w-[28rem] bg-white flex-grow-0 border-4 transition-all hover:transition-all hover:border-micromania-blue">
    <svg id="cart-remove" data-productid="{{id}}" data-optionid="{{id_options}}" class="absolute right-5 top-5 hover:cursor-pointer" xmlns="http://www.w3.org/2000/svg" width="18" height="20" viewBox="0 0 18 20" fill="none">
        <path id="cart-remove" data-productid="{{id}}" data-optionid="{{id_options}}" d="M1 5H17M7 9V15M11 9V15M2 5L3 17C3 17.5304 3.21071 18.0391 3.58579 18.4142C3.96086 18.7893 4.46957 19 5 19H13C13.5304 19 14.0391 18.7893 14.4142 18.4142C14.7893 18.0391 15 17.5304 15 17L16 5M6 5V2C6 1.73478 6.10536 1.48043 6.29289 1.29289C6.48043 1.10536 6.73478 1 7 1H11C11.2652 1 11.5196 1.10536 11.7071 1.29289C11.8946 1.48043 12 1.73478 12 2V5" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
    </svg>
    <div class="w-20 h-32 flex justify-center items-center">
        <img src="./src/assets/{{image}}" alt="{{name}}" class="object-contain h-full">
    </div>
    <div class="flex flex-col justify-between w-full">
        <div class="flex flex-col gap-2">
            <p id="product-link" data-productid="{{id}}" data-optionid="{{id_options}}" class="text-micromania-blue font-semibold hover:text-micromania-darkblue hover:cursor-pointer">
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
            <div class="flex gap-4">
                <p id="cart-stockmessage-{{id}}-{{id_options}}" class="text-generic-grey {{stockhidden}}"><span id="cart-stockleft-{{id}}-{{id_options}}">{{stockleft}}</span> restants</p>
                <div class="flex gap-4 items-center">
                    <p id="cart-decrease" data-productid="{{id}}" data-optionid="{{id_options}}" class="flex h-5 w-5 items-center justify-center rounded text-white font-bold hover:cursor-pointer bg-micromania-blue select-none">-</p>                
                    <p id="cart-amount-{{id}}-{{id_options}}">{{quantite}}</p>
                    <p id="cart-increase" data-productid="{{id}}" data-optionid="{{id_options}}" class="flex h-5 w-5 items-center justify-center rounded text-white font-bold hover:cursor-pointer bg-micromania-blue select-none">+</p>
                </div>
            </div>
        </div>
    </div>
</div>