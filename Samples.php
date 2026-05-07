
<div x-data="tabelaGerencial(<?= htmlspecialchars(json_encode($Listagem)) ?>,['valor'],'FormaPagamento')">

    <table class="w-full text-left [&_td]:p-1 [&_th]:p-2 text-xs" id="tabela1">
        
        <thead>
            <tr class="cursor-pointer select-none bg-gray-100">
                <th @click="sort('data_venc')">ID <span x-show="sortCol === 'data_venc'" x-text="sortAsc ? '↑' : '↓'"></span></th>
            </tr>
        </thead>

        <tbody>
            <template x-for="row in rows" :key="row.id">
                <tr class="border-t">
                    <td><span x-text="row.id"></span></td>
                    <td><span x-text="row.NomeFuncionario"></span></td>
                </tr>
            </template>
        </tbody>

        <tfoot class="bg-gray-100 mt-2">
            <tr>
                <th colspan="5">TOTAL</th>
                <th x-text="somar('valor')" class="text-right"></th>
            </tr>
        </tfoot>
    </table>
</div>
