<bbn-table :source="source"
           :group-by="0"
           :groupable="true"
           :order="[{
             field: 'id_staff',
             dir: 'ASC'
           }]"
           ref="table"
           :editable="true"
           :editor="$options.components.form"
           :data="{
             day: currentDay
           }"
           :filterable="true"
           :filters="planning.currentFilters"
>
  <bbns-column label="<?= _('Staff') ?>"
               field="id_staff"
               :source="staff"
  ></bbns-column>
  <bbns-column label="<?= _('Hours') ?>"
               field="hour"
               :width="100"
               cls="bbn-c"
               :default="0.5"
               :filterable="false"
  ></bbns-column>
  <bbns-column field="recurring"
               :invisible="true"
               :default="0"
  ></bbns-column>
  <bbns-column field="type"
               :invisible="true"
  ></bbns-column>
  <bbns-column field="interval"
               :invisible="true"
  ></bbns-column>
  <bbns-column field="wd"
               :invisible="true"
  ></bbns-column>
  <bbns-column field="md"
               :invisible="true"
  ></bbns-column>
  <bbns-column field="mw"
               :invisible="true"
  ></bbns-column>
  <bbns-column field="ym"
               :invisible="true"
  ></bbns-column>
  <bbns-column field="until"
               :invisible="true"
  ></bbns-column>
  <bbns-column field="occurrences"
               :invisible="true"
  ></bbns-column>
  <bbns-column :buttons="[{
                  text: '<?= _('Edit') ?>',
                  notext: true,
                  action: edit,
                  icon: 'nf nf-fa-edit'
                }, {
                  text: '<?= _('Delete') ?>',
                  notext: true,
                  action: remove,
                  icon: 'nf nf-fa-trash'
                }]"
                :width="90"
                cls="bbn-c"
                v-if="!isEditDisabled"
  ></bbns-column>
</bbn-table>