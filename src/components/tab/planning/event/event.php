<bbn-table :source="source"
           :group-by="0"
           :groupable="true"
           :order="[{
             field: 'nom',
             dir: 'ASC'
           }]"
           ref="table"
           :editable="true"
           :editor="$options.components.form"
           :data="{
             day: currentDay,
             toJSON: toJSON
           }"
>
  <bbns-column title="<?=_('Employe')?>"
               field="id_employe"
               :source="employes"
  ></bbns-column>
  <bbns-column title="<?=_('Entity')?>"
               field="id_entity"
               :render="renderEntity"
  ></bbns-column>
  <bbns-column title="<?=_('Hours')?>"
               field="hour"
               :width="100"
               cls="bbn-c"
               :default="0.5"
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