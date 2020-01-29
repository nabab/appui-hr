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
  <bbns-column title="<?=_('Staff')?>"
               field="id_staff"
               :source="staff"
  ></bbns-column>
  <bbns-column title="<?=_('Hours')?>"
               field="hour"
               :width="100"
               cls="bbn-c"
               :default="0.5"
               :filterable="false"
  ></bbns-column>
  <bbns-column field="recurring"
               :hidden="true"
               :default="0"
  ></bbns-column>
  <bbns-column field="type"
               :hidden="true"
  ></bbns-column>
  <bbns-column field="interval"
               :hidden="true"
  ></bbns-column>
  <bbns-column field="wd"
               :hidden="true"
  ></bbns-column>
  <bbns-column field="md"
               :hidden="true"
  ></bbns-column>
  <bbns-column field="mw"
               :hidden="true"
  ></bbns-column>
  <bbns-column field="ym"
               :hidden="true"
  ></bbns-column>
  <bbns-column field="until"
               :hidden="true"
  ></bbns-column>
  <bbns-column field="occurrences"
               :hidden="true"
  ></bbns-column>
  <bbns-column :buttons="[{
                  text: '<?=_('Edit')?>',
                  notext: true,
                  action: edit,
                  icon: 'nf nf-fa-edit'
                }, {
                  text: '<?=_('Delete')?>',
                  notext: true,
                  action: remove,
                  icon: 'nf nf-fa-trash'
                }]"
                :width="90"
                cls="bbn-c"
                v-if="!isEditDisabled"
  ></bbns-column>
</bbn-table>