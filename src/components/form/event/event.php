<bbn-form :source="source"
          :action="root + 'actions/holidays/' + (source.id ? 'update' : 'insert')"
          :scrollable="false"
          @success="afterSubmit"
          :prefilled="true"
          class="bbn-overlay appui-hr-form-event"
>
  <div class="bbn-padding bbn-grid-fields"
       style="grid-template-columns: max-content auto"
  >
    <label><?= _('From') ?></label>
    <div>
      <bbn-datepicker v-model="source.start"
                      value-format="YYYY-MM-DD 00:00:00"
                      required="required"
      ></bbn-datepicker>
    </div>
    <label><?= _("To") ?></label>
    <div>
      <bbn-datepicker v-model="source.end"
                      value-format="YYYY-MM-DD 23:59:59"
                      :min="source.start"
                      required="required"
      ></bbn-datepicker>
    </div>
    <label><?= _("Type of absence") ?></label>
    <bbn-dropdown :source="absences"
                  v-model="source.id_type"
                  required="required"
    ></bbn-dropdown>
    <label><?= _("Status") ?></label>
    <bbn-dropdown :source="hr.holidaysStatus"
                  v-model="source.status"
                  :nullable="true"
    ></bbn-dropdown>
    <label v-if="!card"><?= _("Staff") ?></label>
    <bbn-dropdown :source="staff"
                  v-model="source.id_staff"
                  v-if="!card"
                  required="required"
    ></bbn-dropdown>
    <label><?= _('Note') ?></label>
    <bbn-textarea v-model="source.note"
                  style="width: 100%; height: 150px"
    ></bbn-textarea>
  </div>
</bbn-form>