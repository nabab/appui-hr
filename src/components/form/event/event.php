<bbn-form :source="source"
          :action="'actions/hr/holidays/' + (source.id ? 'edit' : 'insert')"
          :scrollable="false"
          @success="afterSubmit"
          :prefilled="true"
          class="bbn-overlay ami-hr-form-event"
>
  <div class="bbn-padded bbn-grid-fields"
       style="grid-template-columns: max-content auto"
  >
    <label><?=_('À partir de')?></label>
    <div>
      <bbn-datepicker v-model="source.start"
                      value-format="YYYY-MM-DD 00:00:00"
      ></bbn-datepicker>
    </div>
    <label><?=_("Jusqu'au")?></label>
    <div>
      <bbn-datepicker v-model="source.end"
                      value-format="YYYY-MM-DD 23:59:59"
      ></bbn-datepicker>
    </div>
    <label><?=_("Type d'absence")?></label>
    <bbn-dropdown :source="absences" v-model="source.id_type"></bbn-dropdown>
    <label><?=_("Employé")?></label>
    <bbn-dropdown :source="employees" v-model="source.id_employe"></bbn-dropdown>
    <label><?=_('Note')?></label>
    <bbn-textarea v-model="source.note" 
                  style="width: 100%; height: 150px"
    ></bbn-textarea>
  </div>
</bbn-form>