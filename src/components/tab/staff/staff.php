<div class="appui-hr-tab-staff">
  <bbn-table ref="table"
             :source="root + '/data/staff'"
             class="bbn-100"
             :sortable="true"
             :pageable="true"
             :toolbar="[{
               text: '<?=_('Add')?>',
               action: insert,
               icon: 'nf nf-fa-plus'
             }]"
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
     ></bbns-column>
     <bbns-column title="<?=_('Postal Code')?>"
                  field="cp"
                  :hidden="true"
                  width="100"
     ></bbns-column>
     <bbns-column title="<?=_('City')?>"
                  field="ville"
                  :hidden="true"
     ></bbns-column>
     <bbns-column title="<?=_('Portable')?>"
                  field="tel"
                  :width="200"
                  :hidden="true"
     ></bbns-column>
     <bbns-column field="naissance"
                  :hidden="true"
     ></bbns-column>
     <bbns-column field="contact"
                  :hidden="true"
     ></bbns-column>
     <bbns-column :buttons="buttons"
                  :width="170"
                  cls="bbn-c"
     ></bbns-column>
  </bbn-table>
</div>
