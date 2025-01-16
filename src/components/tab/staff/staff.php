<div class="appui-hr-tab-staff">
  <bbn-table ref="table"
             :source="root + '/data/staff'"
             :sortable="true"
             :pageable="true"
             :toolbar="toolbar"
             editor="appui-hr-form-staff"
             :editable="true"
             :filterable="true"
             :limit="50"
             :order="[{field: 'surname', dir: 'ASC'}]"
             :showable="true"
  >
    <bbns-column field="id"
                  :invisible="true"
                  label="ID"
                  :export="{
                    excluded: false
                  }"
     ></bbns-column>
     <bbns-column field="id_user"
                  :invisible="true"
                  label="<?= _('ID User') ?>"
     ></bbns-column>
     <bbns-column label="<?= _('Name') ?>"
                  field="fullname"
                  :render="renderName"
     ></bbns-column>
     <bbns-column label="<?= _('Group') ?>"
                  field="id_group"
                  :source="groups"
     ></bbns-column>
     <bbns-column label="<?= _('Email') ?>"
                  field="email"
     ></bbns-column>
     <bbns-column label="<?= _('Address') ?>"
                  field="adresse"
                  :hidden="true"
                  :export="{
                    excluded: false,
                    hidden: false
                  }"
     ></bbns-column>
     <bbns-column label="<?= _('Postal Code') ?>"
                  field="cp"
                  :hidden="true"
                  width="100"
                  :export="{
                    excluded: false,
                    hidden: false
                  }"
     ></bbns-column>
     <bbns-column label="<?= _('City') ?>"
                  field="ville"
                  :hidden="true"
                  :export="{
                    excluded: false,
                    hidden: false
                  }"
     ></bbns-column>
     <bbns-column label="<?= _('Mobile') ?>"
                  field="tel"
                  :width="200"
                  :hidden="true"
                  :export="{
                    excluded: false,
                    hidden: false,
                   type: 'string'
                  }"
     ></bbns-column>
     <bbns-column field="naissance"
                  :invisible="true"
                  :export="{
                    excluded: false,
                    hidden: false,
                    title: '<?= _('DoB') ?>'
                  }"
     ></bbns-column>
     <bbns-column field="contact"
                  :invisible="true"
                  :export="{
                   excluded: false,
                    hidden: false,
                    title: '<?= _('Contact') ?>'
                  }"
     ></bbns-column>
     <bbns-column :buttons="buttons"
                  :width="hr.source.perms.write ? 150 : 60"
                  cls="bbn-c"
     ></bbns-column>
  </bbn-table>
</div>
