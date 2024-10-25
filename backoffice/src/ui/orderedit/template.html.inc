<form 
    method="post" 
    id="edit-form"
    data-id="{{id_commandes}}"
    class="fixed flex flex-col bg-white p-5 rounded justify-between w-[60rem] h-[40rem] left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2"
>
    <p class="text-micromania-blue">Commande <span class="text-white">{{id_commandes}}</span></p>
    <p>Date: {{order_date}}</p>
    <p>Client: {{client_name}}</p>
    <p>Email: {{client_email}}</p>
    <label for="status-edit-{{id_commandes}}">Statut:</label>
    {{select_status}}
    <ul class="flex flex-col gap-3 h-1/2 overflow-y-scroll p-5 rounded border-generic-grey">
        {{product_list}}
    </ul>
    <div class="flex justify-center gap-12">
        <div id="edit-submit" class="bg-green-500 px-5 py-2 text-white hover:cursor-pointer rounded">Enregistrer</div>
        <div id="edit-cancel" class="bg-red-500 px-5 py-2 text-white hover:cursor-pointer rounded">Annuler</div>
</form>