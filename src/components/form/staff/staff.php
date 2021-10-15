<bbn-form :source="source.row"
          ref="form"
          :action="root + 'actions/staff/' + (source.row.id ? 'update' : 'create')"
          @success="afterSubmit"

>
  <div class="bbn-padded bbn-grid-fields">
    <label><?=_("Surname")?></label>
    <bbn-input v-model="source.row.surname"
                required="required"
                max-length="50"
    ></bbn-input>
    <label><?=_("Name")?></label>
    <bbn-input v-model="source.row.name"
                required="required"
                max-length="25"
    ></bbn-input>
    <label><?=_("Group")?></label>
    <bbn-dropdown v-model="source.row.id_group"
                  placeholder="<?=_('None')?>"
                  :source="tab.groups"
                  :nullable="true"
    ></bbn-dropdown>
    <label><?=_("Email")?></label>
    <bbn-input v-model="source.row.email"
                type="email"
                max-length="100"
    ></bbn-input>
    <label><?=_("Address")?></label>
    <bbn-input v-model="source.row.adresse"
                max-length="255"
    ></bbn-input>
    <label><?=_("Postal Code")?></label>
    <div>
      <bbn-input v-model="source.row.cp"
                  max-length="5"
      ></bbn-input>
    </div>
    <label><?=_("City")?></label>
    <bbn-input v-model="source.row.ville"
                max-length="255"
    ></bbn-input>
    <label><?=_("Mobile")?></label>
    <div>
      <bbn-input v-model="source.row.tel"
                 max-length="13"
                 pattern="[0-9]{10,13}"
      ></bbn-input>
    </div>
    <label><?=_("Birth")?></label>
    <div>
      <bbn-datepicker v-model="source.row.naissance"
                      :autosize="true"
      ></bbn-datepicker>
    </div>
    <label><?=_("Contact")?></label>
    <bbn-input v-model="source.row.contact"></bbn-input>
  </div>
</bbn-form>
