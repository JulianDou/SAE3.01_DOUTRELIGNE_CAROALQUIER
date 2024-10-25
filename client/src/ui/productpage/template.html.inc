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
        <p id="product-alert" class="font-semibold underline hidden">Attention : Ce produit est en rupture de stock.</p> 
        <div class="flex flex-col gap-3">
            <p class="text-lg md:text-sm"><span class="font-semibold">Option : </span>{{short_name}}</p>
            <div class="flex w-full gap-3 overflow-x-scroll md:flex-wrap md:overflow-hidden">
                {{options}}
            </div>
        </div>
        <p class="text-generic-grey text-lg md:text-base font-light">
            {{description}}
        </p>
        <div class="flex flex-col justify-end gap-3">
            <div class="flex items-end">
                <p class="text-3xl font-bold">{{price}}</p>
                <p class="text-2xl md:text-base font-medium">€</p>
            </div>
            <div>
                <div id="product-instock" class="flex gap-1 hidden items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="9" height="9" viewBox="0 0 9 9" fill="none">
                        <path d="M4.5 0C3.60999 0 2.73996 0.26392 1.99994 0.758387C1.25991 1.25285 0.683138 1.95566 0.342544 2.77792C0.00194977 3.60019 -0.0871652 4.50499 0.0864682 5.37791C0.260102 6.25082 0.688685 7.05264 1.31802 7.68198C1.94736 8.31131 2.74918 8.7399 3.6221 8.91353C4.49501 9.08716 5.39981 8.99805 6.22208 8.65746C7.04434 8.31686 7.74715 7.74009 8.24161 7.00006C8.73608 6.26004 9 5.39002 9 4.5C9 3.30653 8.52589 2.16193 7.68198 1.31802C6.83807 0.474106 5.69348 0 4.5 0ZM3.85714 6.29678L2.25 4.68964L2.76107 4.17857L3.85714 5.27464L6.23893 2.89286L6.75193 3.40264L3.85714 6.29678Z" fill="black"/>
                    </svg>
                    <p>En stock</p>
                </div>
                <div id="product-fewleft" class="flex gap-1 text-generic-grey hidden items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="9" height="9" viewBox="0 0 9 9" fill="none">
                        <path d="M4.5 0C5.69347 0 6.83807 0.474106 7.68198 1.31802C8.52589 2.16193 9 3.30653 9 4.5C9 5.69347 8.52589 6.83807 7.68198 7.68198C6.83807 8.52589 5.69347 9 4.5 9C3.30653 9 2.16193 8.52589 1.31802 7.68198C0.474106 6.83807 0 5.69347 0 4.5C0 3.30653 0.474106 2.16193 1.31802 1.31802C2.16193 0.474106 3.30653 0 4.5 0ZM4.5 1.92857C4.41838 1.9285 4.33765 1.94545 4.26295 1.97834C4.18825 2.01123 4.12124 2.05935 4.06618 2.1196C4.01113 2.17986 3.96925 2.25093 3.94322 2.32829C3.91719 2.40564 3.90758 2.48758 3.915 2.56886L4.14964 5.14414C4.15874 5.23072 4.19957 5.31087 4.26427 5.36913C4.32897 5.42738 4.41294 5.45962 4.5 5.45962C4.58706 5.45962 4.67103 5.42738 4.73573 5.36913C4.80043 5.31087 4.84126 5.23072 4.85036 5.14414L5.08436 2.56886C5.09178 2.48763 5.08218 2.40575 5.05619 2.32844C5.03019 2.25113 4.98837 2.18008 4.93339 2.11984C4.87841 2.05959 4.81147 2.01147 4.73685 1.97854C4.66223 1.94561 4.58156 1.92859 4.5 1.92857ZM4.5 7.07143C4.6364 7.07143 4.76721 7.01724 4.86365 6.9208C4.9601 6.82435 5.01429 6.69354 5.01429 6.55714C5.01429 6.42075 4.9601 6.28994 4.86365 6.19349C4.76721 6.09704 4.6364 6.04286 4.5 6.04286C4.3636 6.04286 4.23279 6.09704 4.13634 6.19349C4.0399 6.28994 3.98571 6.42075 3.98571 6.55714C3.98571 6.69354 4.0399 6.82435 4.13634 6.9208C4.23279 7.01724 4.3636 7.07143 4.5 7.07143Z" fill="#545454"/>
                    </svg>
                    <p>Plus que <span id="product-stock" data-stock="{{stock}}">{{stock}}</span></p>
                </div>
                <div id="product-outofstock"" class="flex gap-1 hidden items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="9" height="9" viewBox="0 0 9 9" fill="none">
                        <path d="M7.70607 1.31297C5.95111 -0.437656 3.07118 -0.437656 1.31622 1.31297C-0.438739 3.06359 -0.438739 5.93641 1.31622 7.68703C3.07118 9.43766 5.90611 9.43766 7.66107 7.68703C9.41602 5.93641 9.46102 3.06359 7.70607 1.31297ZM5.77111 6.38529L4.51114 5.12843L3.25117 6.38529L2.62119 5.75686L3.88116 4.5L2.62119 3.24314L3.25117 2.61471L4.51114 3.87157L5.77111 2.61471L6.4011 3.24314L5.14113 4.5L6.4011 5.75686L5.77111 6.38529Z" fill="#333333"/>
                    </svg>
                    <p>Epuisé</p>
                </div>                
            </div>
            <div id="product-buy-off" class="flex w-full justify-center rounded-md bg-micromania-blue py-6 opacity-50 text-white select-none hidden">
                Ajouter au panier
            </div>
            <div id="product-buy" data-productid="{{id}}" data-optionid="{{id_options}}" class="flex w-full justify-center rounded-md bg-micromania-blue py-6 hover:cursor-pointer hover:bg-micromania-darkblue text-white">
                Ajouter au panier
            </div>
        </div>
    </div>
</div>