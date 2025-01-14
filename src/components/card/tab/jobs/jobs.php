<bbn-table :source="card.root + 'data/card/jobs'"
           :filterable="true"
           :pageable="true"
           :sortable="true"
           :data="{
             id_employe: source.id
           }"
           :order="[{
             field: 'start',
             dir: 'DESC'
           }]"
>
  <bbns-column label="<?= _('Date') ?>"
               field="start"
               type="date"
               :width="120"
               cls="bbn-c"
  ></bbns-column>
  <bbns-column label="<?= _('Hours') ?>"
               field="hour"
               :render="renderHour"
               :width="100"
               cls="bbn-c"
               type="number"
  ></bbns-column>
  <bbns-column label="<?= _('Entity') ?>"
               field="nom"
               :render="renderNom"
  ></bbns-column>
  <bbns-column label="<?= _('Address') ?>"
               field="fulladdress"
               :render="renderAdresse"
  ></bbns-column>
</bbn-table>