<form x-data="{ loading: false }"
    @submit.prevent="
                    loading = true;
                    const form = $event.target;
                    const formData = new FormData(form);
                    try {
                      const res = await fetch('../edit/acesso-query', {
                        method: 'POST',
                        body: formData
                      });

                      const dadosResposta = await res.json();
                      console.log('Mensagem do servidor:', dadosResposta);

                      if (dadosResposta.success) {
                        alert(dadosResposta.msg);
                        console.log(dadosResposta.msg);
                      }

                    } catch (e) {
                      status = 'error';
                      alert('Erro ao processar a resposta do servidor');
                      console.error(e);
                    } finally {
                      loading = false;
                    }
                        "
  >

        <div x-data="{ rows: <?= htmlspecialchars(json_encode($Listagem)) ?> }" class="">

            <div>
              <label>ID:</label>
              <input type="text" :value="rows[0].id" name="id" class="text-center bg-gray-100 cursor-not-allowed" readonly>
            </div>          
            
            <div>
              <label>Ordem:</label>
              <input type="text" name="controle" class="text-center font-bold" :value="rows[0].controle">
            </div>            
            
            <div class="mt-3">
              <label class="clear-both">Abas Selecionadas: </label>
                <div class="grid grid-cols-3 gap-x-8 gap-y-3 mt-3">
                    <template x-for="a in JSON.parse(rows[0].abas)" :key="a.IdAba">
                        <label class="flex items-start gap-2 cursor-pointer">
                            <input type="checkbox" name="abas_acesso[]" class="w-4 h-4 rounded border-gray-300 accent-blue-600 focus:ring-blue-500" :value="a.IdAba" :checked="rows[0].abas_acesso.includes(a.IdAba)"><small x-text="a.OrdAba+' - '+a.DescricaoAba"></small>
                        </label>
                    </template>
                </div>
            </div>

          <div>
            <button type="submit" :disabled="loading" x-text="loading ? 'Atualizando...' : 'Atualizar'" class="btn-gray-xs mt-3">Atualizar</button>
          </div>

        </div>

    </form>
