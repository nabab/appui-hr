<bbn-table source="data/hr/card/jobs"
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
  <bbns-column title="<?=_('Date')?>"
               field="start"
               type="date"
               :width="120"
               cls="bbn-c"
  ></bbns-column>
  <bbns-column title="<?=_('Heures')?>"
               field="hour"
               :render="renderHour"
               :width="100"
               cls="bbn-c"
               type="number"
  ></bbns-column>
  <bbns-column title="<?=_('Chantier')?>"
               field="nom"
               :render="renderNom"
  ></bbns-column>
  <bbns-column title="<?=_('Adresse')?>"
               field="fulladdress"
               :render="renderAdresse"
  ></bbns-column>
</bbn-table>