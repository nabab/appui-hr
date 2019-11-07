<bbn-form action="actions/hr/holidays/replace"
          @success="afterSubmit"
          :source="source"
>
  <div class="bbn-grid-fields bbn-padded">
    <label><?=_('Employé')?></label>
    <bbn-dropdown :source="employes"
                  v-model="source.id_employe"
                  placeholder="<?=_('Choisir')?>"
                  :nullable="true"
    ></bbn-dropdown>
  </div>
</bbn-form>