<form x-data="{ loading: false }"
    @submit.prevent="
                    loading = true;
                    try {
                      const res = await fetch('../EditarObsVencQuery', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify(Object.fromEntries(new FormData($el)))
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
              <label>Observações:</label>
              <textarea name="obs" x-model="rows[0].obs" rows="5" class="w-full p-3 border rounded-xl text-xs"></textarea>
            </div>

          <div>
            <button type="submit" :disabled="loading" x-text="loading ? 'Atualizando...' : 'Atualizar'" class="btn-gray-xs">Atualizar</button>
          </div>

        </div>



    </form>
