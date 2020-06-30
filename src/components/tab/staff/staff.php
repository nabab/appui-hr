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
                  :hidden="true"
                  title="ID"
                  :export="{
                    excluded: false
                  }"
     ></bbns-column>
     <bbns-column field="id_user"
                  :hidden="true"
                  title="<?=_('ID User')?>"
     ></bbns-column>
     <bbns-column title="<?=_('Name')?>"
                  field="fullname"
                  :render="renderName"
     ></bbns-column>
     <bbns-column title="<?=_('Group')?>"
                  field="id_group"
                  :source="groups"
     ></bbns-column>
     <bbns-column title="<?=_('Email')?>"
                  field="email"
     ></bbns-column>
     <bbns-column title="<?=_('Address')?>"
                  field="adresse"
                  :hidden="true"
                  :export="{
                    excluded: false,
                    hidden: false
                  }"
     ></bbns-column>
     <bbns-column title="<?=_('Postal Code')?>"
                  field="cp"
                  :hidden="true"
                  width="100"
                  :export="{
                    excluded: false,
                    hidden: false
                  }"
     ></bbns-column>
     <bbns-column title="<?=_('City')?>"
                  field="ville"
                  :hidden="true"
                  :export="{
                    excluded: false,
                    hidden: false
                  }"
     ></bbns-column>
     <bbns-column title="<?=_('Portable')?>"
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
                  :hidden="true"
                  :export="{
                    excluded: false,
                    hidden: false,
                    title: '<?=_('Naissance')?>'
                  }"
     ></bbns-column>
     <bbns-column field="contact"
                  :hidden="true"
                  :export="{
                   excluded: false,
                    hidden: false,
                    title: '<?=_('Contact')?>'
                  }"
     ></bbns-column>
     <bbns-column :buttons="buttons"
                  :width="hr.source.perms.write ? 150 : 60"
                  cls="bbn-c"
     ></bbns-column>
  </bbn-table>
</div>
