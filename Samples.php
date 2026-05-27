
<!-- VIEW TABELA -->
<div x-data="tabelaGerencial(<?= htmlspecialchars(json_encode($Listagem)) ?>,['valor'],'FormaPagamento')">

    <input 
    type="text" 
    x-model="busca" 
    placeholder="Filtrar por..." 
    class="w-full mb-2 text-center"
    />

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

<div x-data="{ 
    status: '', 
    loading: false,
    rows: <?= htmlspecialchars(json_encode($Listagem)) ?>,
    options: <?= htmlspecialchars(json_encode($ListagemTipoAC)) ?> 
}">

<!-- FORMULARIO PADRAO  -->
<form 
    @submit.prevent="
      loading = true;
      status = '';
      try {
        const res = await fetch('/api', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify(Object.fromEntries(new FormData($el)))
        });
        status = res.ok ? 'success' : 'error';
      } catch (e) {
        status = 'error';
      } finally {
        loading = false;
      }
    "
  >
        <template x-for="(row, index) in rows" :key="row.id">
            <div style="margin-bottom: 10px; border-bottom: 1px solid #ccc;">
                <select name="tipo_ac">
                    <template x-for="opt in options" :key="opt.id">
                        <option :value="opt.id" x-text="opt.titulo"></option>
                    </template>
                </select>
            </div>
        </template>

        <button type="submit" :disabled="loading" x-text="loading ? 'Enviando...' : 'Enviar'"></button>
    </form>

    <!-- Mensagens de Feedback -->
    <template x-if="status === 'success'">
      <p class="text-green-600">Enviado com sucesso!</p>
    </template>

    <template x-if="status === 'error'">
      <p class="text-red-600">Erro ao enviar. Tente novamente.</p>
    </template>

</div>

<!-- CONTROLLER -->
<?php

    public function ExtratoArquivo(): void

    {

        $id = $_GET['id'];
        $DadosExtrato = $this->financeiro->ExtratoArquivo($id);
        $ListarTipoAC = $this->financeiro->ListarTipoAC();

        $this->viewModal('financeiro/ExtratoArquivo', [
            'title'   => 'Detalhes Arquivo - Extrato',
            'DadosExtrato'   => $DadosExtrato,
            'IdExtrato'   => $id,
            'ListarTipoAC' => $ListarTipoAC
        ]);
        
    }    

?>

<!-- MODAL  -->
<?php

    public function ListarTipoAC(): array

    {
        
        return $this->query(
            "SELECT * FROM notas_nf_valorac ORDER BY id ASC",
            []
        );

    }  

?>
